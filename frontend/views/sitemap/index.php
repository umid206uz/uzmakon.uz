<?php
/* @var $urls */
/* @var $host */
echo "<?xml version='1.0' encoding='UTF-8'?>";
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
    <?php foreach ($urls as $url): ?>
        <url>
            <loc><?= $host  . $url['slug'] ?></loc>
            <lastmod><?=$url['time']?></lastmod>
            <changefreq><?= $url['changefreq'] ?></changefreq>
            <priority>1</priority>
        </url>
    <?php endforeach; ?>
</urlset>

