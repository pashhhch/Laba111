namespace App\DTO;

class DatabaseInfoDTO
{
    public $database_name;

    public function __construct($database_name)
    {
        $this->database_name = $database_name;
    }
}
