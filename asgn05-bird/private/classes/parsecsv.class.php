<?php

class ParseCSV
{
    public static $delimiter = ',';

    private $filename = '';
    private $header = [];
    private $data = [];
    private $row_count = 0;

    public function parse($filename)
    {
        $this->reset();
        $this->filename = $filename;

        if (!is_readable($filename)) {
            throw new RuntimeException('CSV file could not be read: ' . $filename);
        }

        $handle = fopen($filename, 'r');
        if ($handle === false) {
            throw new RuntimeException('CSV file could not be opened: ' . $filename);
        }

        $header = fgetcsv($handle, 0, self::$delimiter);
        if ($header === false) {
            fclose($handle);
            return [];
        }

        $this->header = $header;
        $line_number = 1;

        while (($row = fgetcsv($handle, 0, self::$delimiter)) !== false) {
            $line_number++;

            // fgetcsv() can return a one-element row containing NULL or an
            // empty string for a blank line. Skip it so it does not become
            // an empty object in the inventory.
            if (
                $row === [null]
                || (count($row) === 1 && trim((string) $row[0]) === '')
            ) {
                continue;
            }

            if (count($row) !== count($this->header)) {
                fclose($handle);
                throw new UnexpectedValueException(
                    'CSV field count does not match the header on line ' . $line_number . '.'
                );
            }

            $record = array_combine($this->header, $row);
            if ($record === false) {
                fclose($handle);
                throw new UnexpectedValueException(
                    'CSV header and row could not be combined on line ' . $line_number . '.'
                );
            }

            $this->data[] = $record;
            $this->row_count++;
        }

        fclose($handle);
        return $this->data;
    }

    public function last_results()
    {
        return $this->data;
    }

    public function row_count()
    {
        return $this->row_count;
    }

    private function reset()
    {
        $this->filename = '';
        $this->header = [];
        $this->data = [];
        $this->row_count = 0;
    }
}
