<?php
/**
 * CleanNora Festival Theme Engine
 * Visual-only seasonal layer. Existing page layout/content/functionality stays unchanged.
 */

if (!function_exists('cnFestivalTheme')) {
    function cnFestivalTheme(): array
    {
        date_default_timezone_set('Asia/Kolkata');
        $today = new DateTimeImmutable('today');

        $themes = [
            [
                'slug'  => 'janmashtami',
                'name'  => 'Janmashtami',
                // Theme begins the day before and ends after the festival day.
                'start' => '2026-09-03',
                'end'   => '2026-09-05',
            ],
        ];

        foreach ($themes as $theme) {
            $start = new DateTimeImmutable($theme['start']);
            $end   = new DateTimeImmutable($theme['end']);
            if ($today >= $start && $today <= $end) {
                return $theme + ['active' => true];
            }
        }

        return ['active' => false, 'slug' => '', 'name' => ''];
    }
}

$cnFestival = cnFestivalTheme();
