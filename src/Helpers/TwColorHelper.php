<?php

namespace DataArkadia\LaravelSettings\Helpers;

class TwColorHelper
{
    public static function colors()
    {
        return collect([
            'slate' => [
                '100' => '#f8fafc', '200' => '#f1f5f9', '300' => '#e2e8f0', '400' => '#cbd5e1', '500' => '#94a3b8', '600' => '#64748b', '700' => '#475569', '800' => '#334155', '900' => '#1e293b', '1000' => '#0f172a',
            ],
            'gray' => [
                '100' => '#f9fafb', '200' => '#f3f4f6', '300' => '#e5e7eb', '400' => '#d1d5db', '500' => '#9ca3af', '600' => '#6b7280', '700' => '#4b5563', '800' => '#374151', '900' => '#1f2937', '1000' => '#111827',
            ],
            'zinc' => [
                '100' => '#fafafa', '200' => '#f4f4f5', '300' => '#e4e4e7', '400' => '#d4d4d8', '500' => '#a1a1aa', '600' => '#71717a', '700' => '#52525b', '800' => '#3f3f46', '900' => '#27272a', '1000' => '#18181b',
            ],
            'neutral' => [
                '100' => '#fafafa', '200' => '#f5f5f5', '300' => '#e5e5e5', '400' => '#d4d4d4', '500' => '#a3a3a3', '600' => '#737373', '700' => '#525252', '800' => '#404040', '900' => '#262626', '1000' => '#171717',
            ],
            'stone' => [
                '100' => '#fafaf9', '200' => '#f5f5f4', '300' => '#e7e5e4', '400' => '#d6d3d1', '500' => '#a8a29e', '600' => '#78716c', '700' => '#57534e', '800' => '#44403c', '900' => '#292524', '1000' => '#1c1917',
            ],
            'red' => [
                '100' => '#fef2f2', '200' => '#fee2e2', '300' => '#fecaca', '400' => '#fca5a5', '500' => '#f87171', '600' => '#ef4444', '700' => '#dc2626', '800' => '#b91c1c', '900' => '#991b1b', '1000' => '#7f1d1d',
            ],
            'orange' => [
                '100' => '#fff7ed', '200' => '#ffedd5', '300' => '#fed7aa', '400' => '#fdba74', '500' => '#fb923c', '600' => '#f97316', '700' => '#ea580c', '800' => '#c2410c', '900' => '#9a3412', '1000' => '#7c2d12',
            ],
            'amber' => [
                '100' => '#fffbeb', '200' => '#fef3c7', '300' => '#fde68a', '400' => '#fcd34d', '500' => '#fbbf24', '600' => '#f59e0b', '700' => '#d97706', '800' => '#b45309', '900' => '#92400e', '1000' => '#78350f',
            ],
            'yellow' => [
                '100' => '#fefce8', '200' => '#fef9c3', '300' => '#fef08a', '400' => '#fde047', '500' => '#facc15', '600' => '#eab308', '700' => '#ca8a04', '800' => '#a16207', '900' => '#854d0e', '1000' => '#713f12',
            ],
            'lime' => [
                '100' => '#f7fee7', '200' => '#ecfccb', '300' => '#d9f99d', '400' => '#bef264', '500' => '#a3e635', '600' => '#84cc16', '700' => '#65a30d', '800' => '#4d7c0f', '900' => '#3f6212', '1000' => '#365314',
            ],
            'green' => [
                '100' => '#f0fdf4', '200' => '#dcfce7', '300' => '#bbf7d0', '400' => '#86efac', '500' => '#4ade80', '600' => '#22c55e', '700' => '#16a34a', '800' => '#15803d', '900' => '#166534', '1000' => '#14532d',
            ],
            'emerald' => [
                '100' => '#ecfdf5', '200' => '#d1fae5', '300' => '#a7f3d0', '400' => '#6ee7b7', '500' => '#34d399', '600' => '#10b981', '700' => '#059669', '800' => '#047857', '900' => '#065f46', '1000' => '#064e3b',
            ],
            'teal' => [
                '100' => '#f0fdfa', '200' => '#ccfbf1', '300' => '#99f6e4', '400' => '#5eead4', '500' => '#2dd4bf', '600' => '#14b8a6', '700' => '#0d9488', '800' => '#0f766e', '900' => '#115e59', '1000' => '#134e4a',
            ],
            'cyan' => [
                '100' => '#ecfeff', '200' => '#cffafe', '300' => '#a5f3fc', '400' => '#67e8f9', '500' => '#22d3ee', '600' => '#06b6d4', '700' => '#0891b2', '800' => '#0e7490', '900' => '#155e75', '1000' => '#164e63',
            ],
            'sky' => [
                '100' => '#f0f9ff', '200' => '#e0f2fe', '300' => '#bae6fd', '400' => '#7dd3fc', '500' => '#38bdf8', '600' => '#0ea5e9', '700' => '#0284c7', '800' => '#0369a1', '900' => '#075985', '1000' => '#0c4a6e',
            ],
            'blue' => [
                '100' => '#eff6ff', '200' => '#dbeafe', '300' => '#bfdbfe', '400' => '#93c5fd', '500' => '#60a5fa', '600' => '#3b82f6', '700' => '#2563eb', '800' => '#1d4ed8', '900' => '#1e40af', '1000' => '#1e3a8a',
            ],
            'indigo' => [
                '100' => '#eef2ff', '200' => '#e0e7ff', '300' => '#c7d2fe', '400' => '#a5b4fc', '500' => '#818cf8', '600' => '#6366f1', '700' => '#4f46e5', '800' => '#4338ca', '900' => '#3730a3', '1000' => '#312e81',
            ],
            'violet' => [
                '100' => '#f5f3ff', '200' => '#ede9fe', '300' => '#ddd6fe', '400' => '#c4b5fd', '500' => '#a78bfa', '600' => '#8b5cf6', '700' => '#7c3aed', '800' => '#6d28d9', '900' => '#5b21b6', '1000' => '#4c1d95',
            ],
            'purple' => [
                '100' => '#faf5ff', '200' => '#f3e8ff', '300' => '#e9d5ff', '400' => '#d8b4fe', '500' => '#c084fc', '600' => '#a855f7', '700' => '#9333ea', '800' => '#7e22ce', '900' => '#6b21a8', '1000' => '#581c87',
            ],
            'fuchsia' => [
                '100' => '#fdf4ff', '200' => '#fae8ff', '300' => '#f5d0fe', '400' => '#f0abfc', '500' => '#e879f9', '600' => '#d946ef', '700' => '#c026d3', '800' => '#a21caf', '900' => '#86198f', '1000' => '#701a75',
            ],
            'pink' => [
                '100' => '#fdf2f8', '200' => '#fce7f3', '300' => '#fbcfe8', '400' => '#f9a8d4', '500' => '#f472b6', '600' => '#ec4899', '700' => '#db2777', '800' => '#be185d', '900' => '#9d174d', '1000' => '#831843',
            ],
            'rose' => [
                '100' => '#fff1f2', '200' => '#ffe4e6', '300' => '#fecdd3', '400' => '#fda4af', '500' => '#fb7185', '600' => '#f43f5e', '700' => '#e11d48', '800' => '#be123c', '900' => '#9f1239', '1000' => '#881337',
            ],
        ]);
    }

    public static function fromSetting(string $role, ?string $shade = null)
    {
        $settingValue = setting("colors.$role");

        if ($settingValue) {
            $valueParts = explode('_', $settingValue); // Example $settingValue: tw_slate_100
            $colorName = $valueParts[1]; // Gives: slate
            $colorShade = (int) $valueParts[2]; // Gives: 100
            $color = self::colors()->toArray()[$colorName]; // Returns all shades of slate

            if ($shade) {
                switch ($role) {
                    case 'primary-color':
                        $corrections = [
                            'd1' => 100,
                            'd2' => 200,
                            'd3' => 600,
                            // Buttons:
                            'bbg' => 200,
                            'bbd' => 400,
                            'bbt' => 600,
                                'bbgh' => 300,
                                'bbdh' => 500,
                                'bbth' => 600,
                                    'bbga' => 300,
                                    'bbda' => 500,
                                    'bbta' => 600,
                        ];

                        $correction = $corrections[$shade];

                        if ($colorShade > 400) {
                            $correction *= -1;
                        }
                        break;
                    
                    case 'secondary-color':
                        $corrections = [
                            'd1' => 300,
                            'd2' => 600,
                        ];

                        $correction = $corrections[$shade];

                        if ($colorShade > 400) {
                            $correction *= -1;
                        }
                        break;

                    case 'accent-color':
                        $corrections = [
                            's1' => -100,
                            'd1' => 100,
                            // Buttons:
                            'bbg' => 0,
                            'bbd' => 200,
                            'bbt' => 600,
                                'bbgh' => 100,
                                'bbdh' => 300,
                                'bbth' => 900,
                                    'bbga' => 100,
                                    'bbda' => 300,
                                    'bbta' => 900,
                        ];

                        $correction = $corrections[$shade];

                        if (in_array($shade, ['bbt', 'bbth', 'bbta'])) {
                            if ($colorShade >= 600) {
                                return '#ffffff';
                            }
                        }
                        break;
                }

                $index = $colorShade + $correction;

                if ($index > 1000) {
                    $index = 1000;
                } elseif ($index <= 0) {
                    $index = 100;
                }

                $color = $color[$index];
            } else {
                if ($colorShade == 100) {
                    $color = '#ffffff';
                } else {
                    $color = $color[$colorShade];
                }
            }

            return $color;
        }

        return null;
    }

    public static function shadeValue(string $role)
    {
        $settingValue = setting($role);

        if ($settingValue) {
            $valueParts = explode('_', $settingValue);
            $colorShade = (int) $valueParts[2];

            return $colorShade;
        }

        return '';
    }
}
