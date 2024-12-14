<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

class SitesSettings extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('sites.site_name', '3x1');
        $this->migrator->add('sites.site_description', 'Aplikasi Monitoring Divisi Bisnis');
        $this->migrator->add('sites.site_keywords', 'Bank, BPR, Bisnis, Kredit');
        $this->migrator->add('sites.site_profile', '');
        $this->migrator->add('sites.site_logo', '');
        $this->migrator->add('sites.site_author', 'Agus Maulana Y');
        $this->migrator->add('sites.site_address', 'Subang, Jawa Barat');
        $this->migrator->add('sites.site_email', 'info@3x1.io');
        $this->migrator->add('sites.site_phone', '+201207860084');
        $this->migrator->add('sites.site_phone_code', '+62');
        $this->migrator->add('sites.site_location', 'Subang, Jawa Barat');
        $this->migrator->add('sites.site_currency', 'IDR');
        $this->migrator->add('sites.site_language', 'English');
        $this->migrator->add('sites.site_social', []);
    }
}
