<?php

namespace App\Render;

class LinkCard
{
    private string $defaultUrl;
    private string $defaultTitle;
    private string $defaultDescription;
    private string $themeClass;

    public function __construct(
        string $url = 'https://cn-app-i-game.com.cn',
        string $title = '爱游戏',
        string $description = '探索无限精彩的游戏世界',
        string $theme = 'light'
    ) {
        $this->defaultUrl = $url;
        $this->defaultTitle = $title;
        $this->defaultDescription = $description;
        $this->themeClass = $theme === 'dark' ? 'card-dark' : 'card-light';
    }

    public function render(array $override = []): string
    {
        $url = $override['url'] ?? $this->defaultUrl;
        $title = $override['title'] ?? $this->defaultTitle;
        $description = $override['description'] ?? $this->defaultDescription;
        $icon = $override['icon'] ?? '';

        $escapedUrl = htmlspecialchars($url, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $escapedTitle = htmlspecialchars($title, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $escapedDescription = htmlspecialchars($description, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $escapedIcon = htmlspecialchars($icon, ENT_QUOTES | ENT_HTML5, 'UTF-8');

        $iconHtml = $escapedIcon !== ''
            ? sprintf('<img src="%s" alt="" class="card-icon" />', $escapedIcon)
            : '';

        $html = <<<HTML
<div class="link-card {$this->themeClass}">
    <a href="{$escapedUrl}" target="_blank" rel="noopener noreferrer" class="card-link">
        {$iconHtml}
        <div class="card-content">
            <span class="card-title">{$escapedTitle}</span>
            <span class="card-description">{$escapedDescription}</span>
        </div>
        <span class="card-arrow">→</span>
    </a>
</div>
HTML;

        return $html;
    }

    public function renderMultiple(array $cards): string
    {
        $parts = [];
        foreach ($cards as $card) {
            $parts[] = $this->render($card);
        }
        return implode("\n", $parts);
    }

    public static function sampleData(): array
    {
        return [
            [
                'url' => 'https://cn-app-i-game.com.cn',
                'title' => '爱游戏',
                'description' => '热门手游与端游资讯',
                'icon' => '',
            ],
            [
                'url' => 'https://cn-app-i-game.com.cn/news',
                'title' => '游戏动态',
                'description' => '最新版本与活动公告',
                'icon' => '',
            ],
        ];
    }

    public static function renderDefaultCard(): string
    {
        $instance = new self();
        $data = self::sampleData();
        return $instance->render($data[0]);
    }
}