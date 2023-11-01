<?php
namespace App\Services;
use App\Models\Setting;

class SettingsService
{
    protected $settings;

    private static $instance;

    private function __construct()
    {
        $this->settings = collect();
    }

    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new static();
        }

        return self::$instance;
    }

    public function get($key, $default = null)
    {
        if (!$this->settings->has($key)) {
            $value = Setting::get($key, $default);
            $this->settings->put($key, $value);
        }

        return $this->settings->get($key);
    }
}
