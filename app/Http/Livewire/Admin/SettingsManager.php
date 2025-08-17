<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Setting;
use Illuminate\Support\Facades\Storage;

class SettingsManager extends Component
{
    use WithFileUploads;

    public $groups = [];
    public $activeGroup = 'general';
    public $settings = [];
    public $tempImages = [];
    public $availableGroups = [
        'general' => 'General',
        'contact' => 'Contact Information',
        'social' => 'Social Media',
        'seo' => 'SEO Settings',
        // 'appearance' => 'Appearance',
        // 'email' => 'Email Settings',
    ];

    protected $listeners = ['groupChanged' => 'changeGroup'];

    public function mount()
    {
        $this->loadGroups();
        $this->loadSettings($this->activeGroup);
    }

    public function loadGroups()
    {
        $this->groups = Setting::select('group')
            ->distinct()
            ->get()
            ->pluck('group')
            ->toArray();

        // Add default groups if they don't exist
        foreach ($this->availableGroups as $key => $label) {
            if (!in_array($key, $this->groups)) {
                $this->groups[] = $key;
            }
        }
    }

    public function loadSettings($group)
    {
        $this->activeGroup = $group;
        $settings = Setting::where('group', $group)->get();

        // Initialize with default settings if none exist
        if ($settings->isEmpty()) {
            $this->initializeDefaultSettings($group);
            $settings = Setting::where('group', $group)->get();
        }

        foreach ($settings as $setting) {
            $this->settings[$setting->key] = $setting->value;
        }
    }

    protected function initializeDefaultSettings($group)
    {
        $defaultSettings = $this->getDefaultSettings($group);

        foreach ($defaultSettings as $key => $config) {
            Setting::create([
                'key' => $key,
                'value' => $config['value'] ?? '',
                'type' => $config['type'] ?? 'text',
                'group' => $group,
                'options' => $config['options'] ?? null
            ]);
        }
    }

    protected function getDefaultSettings($group)
    {
        $defaults = [
            'general' => [
                'site_name' => [
                    'value' => 'Kaynat Precision in Motion',
                    'type' => 'text'
                ],
                'site_tagline' => [
                    'value' => 'Advanced GPS Tracking Solutions',
                    'type' => 'text'
                ],
                'site_logo' => [
                    'value' => '',
                    'type' => 'image'
                ],
                'site_favicon' => [
                    'value' => '',
                    'type' => 'image'
                ],
                // 'default_language' => [
                //     'value' => 'en',
                //     'type' => 'select',
                //     'options' => ['en' => 'English', 'fa' => 'فارسی', 'ps' => 'پښتو']
                // ],
                'timezone' => [
                    'value' => 'Asia/Kabul',
                    'type' => 'select',
                    'options' => [
                        'Asia/Kabul' => 'Kabul (GMT+4:30)',
                        'UTC' => 'UTC (GMT+0)',
                        // Add more timezones as needed
                    ]
                ],
                'date_format' => [
                    'value' => 'd M Y',
                    'type' => 'text'
                ],
            ],
            'contact' => [
                'company_address' => [
                    'value' => 'Kabul, Afghanistan',
                    'type' => 'text'
                ],
                'contact_email' => [
                    'value' => 'info@kaynat.com',
                    'type' => 'email'
                ],
                'contact_phone' => [
                    'value' => '+93 700 000 000',
                    'type' => 'text'
                ],
                'contact_phone_secondary' => [
                    'value' => '',
                    'type' => 'text'
                ],
                'business_hours' => [
                    'value' => 'Saturday - Thursday: 8:00 - 17:00',
                    'type' => 'text'
                ],
            ],
            'social' => [
                'facebook_url' => [
                    'value' => '',
                    'type' => 'text'
                ],
                'twitter_url' => [
                    'value' => '',
                    'type' => 'text'
                ],
                'linkedin_url' => [
                    'value' => '',
                    'type' => 'text'
                ],
                'instagram_url' => [
                    'value' => '',
                    'type' => 'text'
                ],
                'youtube_url' => [
                    'value' => '',
                    'type' => 'text'
                ],
            ],
            'seo' => [
                'meta_title' => [
                    'value' => 'Kaynat | Precision in Motion',
                    'type' => 'text'
                ],
                'meta_description' => [
                    'value' => 'Advanced GPS tracking solutions for fleet management, asset tracking, and personal safety',
                    'type' => 'textarea'
                ],
                'meta_keywords' => [
                    'value' => 'gps tracking, fleet management, asset tracking, vehicle tracking',
                    'type' => 'text'
                ],
                'google_analytics_code' => [
                    'value' => '',
                    'type' => 'textarea'
                ],
            ],
            'appearance' => [
                'primary_color' => [
                    'value' => '#1a3a8f',
                    'type' => 'color'
                ],
                'secondary_color' => [
                    'value' => '#ff6b35',
                    'type' => 'color'
                ],
                'accent_color' => [
                    'value' => '#00a8e8',
                    'type' => 'color'
                ],
                'dark_mode' => [
                    'value' => 'auto',
                    'type' => 'select',
                    'options' => [
                        'auto' => 'Auto (System Preference)',
                        'light' => 'Light Mode',
                        'dark' => 'Dark Mode'
                    ]
                ],
            ],
            'email' => [
                'mail_from_address' => [
                    'value' => 'noreply@kaynat.com',
                    'type' => 'email'
                ],
                'mail_from_name' => [
                    'value' => 'Kaynat Support',
                    'type' => 'text'
                ],
                'mail_mailer' => [
                    'value' => 'smtp',
                    'type' => 'select',
                    'options' => [
                        'smtp' => 'SMTP',
                        'sendmail' => 'Sendmail',
                        'mailgun' => 'Mailgun',
                        'ses' => 'Amazon SES'
                    ]
                ],
                'mail_host' => [
                    'value' => '',
                    'type' => 'text'
                ],
                'mail_port' => [
                    'value' => '587',
                    'type' => 'text'
                ],
                'mail_username' => [
                    'value' => '',
                    'type' => 'text'
                ],
                'mail_password' => [
                    'value' => '',
                    'type' => 'password'
                ],
                'mail_encryption' => [
                    'value' => 'tls',
                    'type' => 'select',
                    'options' => [
                        '' => 'None',
                        'tls' => 'TLS',
                        'ssl' => 'SSL'
                    ]
                ],
            ]
        ];

        return $defaults[$group] ?? [];
    }

    public function changeGroup($group)
    {
        $this->activeGroup = $group;
        $this->loadSettings($group);
    }

    public function saveSettings()
    {
        foreach ($this->settings as $key => $value) {
            $setting = Setting::where('key', $key)->first();

            // Handle image uploads
            if ($setting && $setting->type === 'image' && isset($this->tempImages[$key])) {
                // Delete old image if exists
                if ($setting->value) {
                    Storage::disk('public')->delete($setting->value);
                }

                // Store new image
                $path = $this->tempImages[$key]->store('settings', 'public');
                $value = $path;
                unset($this->tempImages[$key]);
            }

            if ($setting) {
                $setting->update(['value' => $value]);
            } else {
                // Create new setting if it doesn't exist
                $group = $this->activeGroup;
                Setting::create([
                    'key' => $key,
                    'value' => $value,
                    'type' => 'text', // default type
                    'group' => $group
                ]);
            }
        }

        // Clear temp images
        $this->tempImages = [];

        $this->dispatchBrowserEvent('notify', [
            'type' => 'success',
            'message' => 'Settings updated successfully!'
        ]);
    }

    public function render()
    {
        $settingsData = Setting::where('group', $this->activeGroup)->get();
        $settingsConfig = [];

        foreach ($settingsData as $setting) {
            $settingsConfig[$setting->key] = [
                'type' => $setting->type,
                'options' => $setting->options
            ];
        }

        return view('livewire.admin.settings-manager', [
            'settingsConfig' => $settingsConfig,
            'groups' => $this->groups,
            'availableGroups' => $this->availableGroups
        ])->layout('layouts.admin');
    }
}
