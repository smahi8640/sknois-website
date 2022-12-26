<?php 
namespace App\Libraries;

use CodeIgniter\Database\Exceptions\DatabaseException;
use ZipArchive;

/**
 * The MyCustomBackup class is a basic port of the CodeIgniter 3 backup module for 
 * CodeIgniter 4.
 *
 * @package    App\Libraries
 *
 * @author     Ocian Team
 */

class MyCustomBackup
{

    protected $db;
    public function __construct($db)
	{
		$this->db = & $db;
	}
    public function backup_zip($params = [])
    {
        // If the parameters have not been submitted as an
        // array then we know that it is simply the table
        // name, which is a valid short cut.
        if (is_string($params))
        {
            $params = ['tables' => $params];
        }

        // Set up our default preferences
        $prefs = [
            'tables'             => [],
            'ignore'             => [],
            'filename'           => '',
            'format'             => 'gzip', // gzip, txt
            'add_drop'           => true,
            'add_insert'         => true,
            'newline'            => "\n",
            'foreign_key_checks' => true,
        ];

        // Did the user submit any preferences? If so set them....
        if (! empty($params))
        {
            foreach ($prefs as $key => $val)
            {
                if (isset($params[$key]))
                {
                    $prefs[$key] = $params[$key];
                }
            }
        }

        // Are we backing up a complete database or individual tables?
        // If no table names were submitted we'll fetch the entire table list
        if (empty($prefs['tables']))
        {
            $prefs['tables'] = $this->db->listTables();
        }
        // Was a Zip file requested?
        if ($prefs['format'] === 'zip')
        {
            // Set the filename if not provided (only needed with Zip files)
            if ($prefs['filename'] === '')
            {
                $prefs['filename'] = (count($prefs['tables']) === 1 ? $prefs['tables'] : $this->db->database)
                            .date('Y-m-d_H-i', time()).'.sql';
            }
            else
            {
                // If they included the .zip file extension we'll remove it
                if (preg_match('|.+?\.zip$|', $prefs['filename']))
                {
                    $prefs['filename'] = str_replace('.zip', '', $prefs['filename']);
                }

                // Tack on the ".sql" file extension if needed
                if ( ! preg_match('|.+?\.sql$|', $prefs['filename']))
                {
                    $prefs['filename'] .= '.sql';
                }
            }

            // Load the Zip class and output it
            $zip = new ZipArchive();
            $zipname = 'backup-on-'. date("Y-m-d-H-i-s") .'.zip';
            $tmp_file = tempnam('.','');
            $zip->open($zipname, ZipArchive::CREATE);
            $zip->addFromString($prefs['filename'],$this->generate_backup($prefs));
            $zip->close();
            return true;
        }
        else{
            throw new DatabaseException('Unsupported feature of the database platform you are using.');
        }
    }

    public function generate_backup(array $params = null){
        if (count($params) === 0)
        {
            return FALSE;
        }
        
        // Extract the prefs for simplicity
        extract($params);
    
        // Build the output
        $output = '';
    
        // Do we need to include a statement to disable foreign key checks?
        if ($foreign_key_checks === FALSE)
        {
            $output .= 'SET foreign_key_checks = 0;'.$newline;
        }
        
        foreach ( (array) $tables as $table)
        {
            // Is the table in the "ignore" list?
            if (in_array($table, (array) $ignore, TRUE))
            {
                continue;
            }
    
            // Get the table schema
            $query = $this->db->query('SHOW CREATE TABLE '.$this->db->escapeString($this->db->database.'.'.$table));
    
            // No result means the table name was invalid
            if ($query === FALSE)
            {
                continue;
            }
    
            // Write out the table schema
            $output .= '#'.$newline.'# TABLE STRUCTURE FOR: '.$table.$newline.'#'.$newline.$newline;
    
            if ($add_drop === TRUE)
            {
                $output .= 'DROP TABLE IF EXISTS '.$this->db->protectIdentifiers($table).';'.$newline.$newline;
            }
    
            $i = 0;
            $result = $query->getResultArray();
            foreach ($result[0] as $val)
            {
                if ($i++ % 2)
                {
                    $output .= $val.';'.$newline.$newline;
                }
            }
    
            // If inserts are not needed we're done...
            if ($add_insert === FALSE)
            {
                continue;
            }
    
            // Grab all the data from the current table
            $query = $this->db->query('SELECT * FROM '.$this->db->protectIdentifiers($table));
            
            if (empty($query->getResultArray()))
            {
                continue;
            }
    
            // Fetch the field names and determine if the field is an
            // integer type. We use this info to decide whether to
            // surround the data with quotes or not
    
            $i = 0;
            $field_str = '';
            $is_int = array();
            $fields = $query->getFieldData();
            foreach($fields as $field)
            {
                // Most versions of MySQL store timestamp as a string
                $is_int[$i] = in_array($field->type, array(MYSQLI_TYPE_TINY, MYSQLI_TYPE_SHORT, MYSQLI_TYPE_INT24, MYSQLI_TYPE_LONG), TRUE);
    
                // Create a string of field names
                $field_str .= $this->db->escapeString($field->name).', ';
                $i++;
            }
    
            // Trim off the end comma
            $field_str = preg_replace('/, $/' , '', $field_str);
    
            // Build the insert string
            foreach ($query->getResultArray() as $row)
            {
                $val_str = '';
    
                $i = 0;
                foreach ($row as $v)
                {
                    // Is the value NULL?
                    if ($v === NULL)
                    {
                        $val_str .= 'NULL';
                    }
                    else
                    {
                        // Escape the data if it's not an integer
                        $val_str .= ($is_int[$i] === FALSE) ? $this->db->escape($v) : $v;
                    }
    
                    // Append a comma
                    $val_str .= ', ';
                    $i++;
                }
    
                // Remove the comma at the end of the string
                $val_str = preg_replace('/, $/' , '', $val_str);
    
                // Build the INSERT string
                $output .= 'INSERT INTO '.$this->db->protectIdentifiers($table).' ('.$field_str.') VALUES ('.$val_str.');'.$newline;
            }
    
            $output .= $newline.$newline;
        }
    
        // Do we need to include a statement to re-enable foreign key checks?
        if ($foreign_key_checks === FALSE)
        {
            $output .= 'SET foreign_key_checks = 1;'.$newline;
        }
    
        return $output;
    }
}