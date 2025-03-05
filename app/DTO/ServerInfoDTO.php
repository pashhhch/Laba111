namespace App\DTO;

class ServerInfoDTO
{
    public $php_version;

    public function __construct($php_version)
    {
        $this->php_version = $php_version;
    }
}
