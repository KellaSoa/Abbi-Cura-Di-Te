<?php

class UserCRM
{
    private $wpdb;
    protected static ?UserCRM $instance = null;
    private $table_name;
    private $csv_file;
    private $log_file;
    private $log_details;

    protected function __construct()
    {
        self::$instance = &$this;
        global $wpdb;
        $this->wpdb = $wpdb;
        $this->table_name =$this->wpdb->prefix . "crm_user";
        $this->csv_file = CRM_FTP_PATH.'/export-TUR.csv';
        $this->log_file = CRM_FTP_PATH.'/log_file_import_csv.log';
        $this->log_details = CRM_FTP_PATH.'/log_import_csv.log';
    }

    public static function Instance(): UserCRM
    {
        return is_null(self::$instance) ? new UserCRM() : self::$instance;
    }

    public function truncateTableAndLog(){
        //truncate table
        $this->wpdb->query("TRUNCATE TABLE $this->table_name");
        // make the log file with 0
        file_put_contents($this->log_file, 0);
        // delete last log
        file_put_contents($this->log_details, "");
    }
    public function CSVProcessor(){
        // Open the log file for writing (append mode)
        $log_handle = fopen($this->log_file, 'a');
        $log_handle_details = fopen($this->log_details, 'a');
        $start_time = date('Y-m-d H:i:s');
        fwrite($log_handle_details, "Table crm_user truncated successfully\n");
        fwrite($log_handle_details, "Import started at $start_time\n");

        // Get the last processed line from a log file
        $lastProcessedLine = file_exists($this->log_file) ? (int)file_get_contents($this->log_file) : 0;

        // Define batch size
        $batchSize = 1000;

        // Calculate the start and end points for the current batch
        $startLine = $lastProcessedLine + 1;
        $endLine = $startLine + $batchSize - 1;

        $delimiter = ';';

        // Open the CSV file
        if (($handle = fopen($this->csv_file, 'r')) !== false) {
            // Skip already processed lines
            for ($i = 0; $i < $lastProcessedLine; $i++) {
                fgetcsv($handle, 1000, $delimiter);
            }
            // Process the next batch of lines
            while ($startLine <= $endLine && ($data = fgetcsv($handle, 1000, $delimiter)) !== false) {
                // Process the data
                // $data is an array containing the CSV fields
                $user =  $this->wpdb->insert($this->table_name, [
                    'idDipendente' => $data[0],
                    'Cognome' => $data[1],
                    'Nome' => $data[2],
                    'Indirizzo' => $data[3],
                    'Localita' => $data[4],
                    'Cap' => $data[5],
                    'Provincia' => $data[6],
                    'Email' => $data[7],
                    'CodiceFiscale' => $data[8],
                    'Sesso' => $data[9],
                    'DataNascita' => $data[10],
                    'idAzienda' => $data[12],
                    'RagioneSociale' => $data[13],
                    'IndirizzoAzienda' => $data[15],
                    'EmailAzienda' => $data[19],
                    'PartitaIva' => $data[20],
                    'CodiceFiscaleAzienda' => $data[21],
                ]);
                file_put_contents($this->log_file, implode(',', $data) . "\n", FILE_APPEND);
                if ($user) {
                    // Log successful user creation
                    $success_message = "User created: idDipendente: $data[0], Cognome: $data[1], Nome: $data[2]";
                    // Append the processed data to the log file
                    fwrite($log_handle_details, "$success_message\n");
                } else {
                    // Log skipped user
                    $skipped_message = "User skipped : idDipendente: $data[0], Cognome: $data[1], Nome: $data[2]";
                    fwrite($log_handle_details, "$skipped_message\n");
                }
                $startLine++;
            }

            fclose($handle);

            // Update the log file with the last processed line
            file_put_contents($this->log_file, $lastProcessedLine + $startLine);

            $totalLines = count(file($this->csv_file));
            $batchGroup = $lastProcessedLine + $startLine;
            fwrite($log_handle_details, "totalLines: $totalLines\n");
            fwrite($log_handle_details, "execute the next: $batchGroup\n Lines");
            // Trigger the script again if there are more lines to process
            if ($startLine <= $totalLines) {
                //fwrite($log_handle_details, "execute the next 1000 Lines\n");
                exec('php '.$this->CSVProcessor());
            }
            else{
                fwrite($log_handle_details, "End Export Lines");
            }
        } else {
            echo "Error opening file!";
        }
    }

    public function getUserById($id){
        $sql = "SELECT * FROM `wp_crm_user` WHERE `idDipendente` =$id";
        return $this->wpdb->get_results($this->wpdb->prepare($sql));
    }
}
UserCRM::Instance();

//Commande terminal execute cron
// wp eval 'do_action( "custom_csv_event" );'
// http://localhost/Abbi-Cura-Di-Te/wp-admin/admin-ajax.php?action=trigger_custom_event
// wp eval-file trigger_custom_event.php