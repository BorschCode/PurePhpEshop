<?php
/**
 * Admin Header Template with Breadcrumbs
 *
 * Alternative header template specifically designed for admin pages.
 * Includes SEO meta tags, canonical URLs, robots directives, and
 * structured breadcrumb navigation with microdata markup.
 *
 * @var string $pageTitle Page title for the <title> tag
 * @var string $pageDescription Meta description content
 * @var string|null $pageCanonical Canonical URL for SEO (optional)
 * @var string|null $pageRobots Robots meta tag content (optional)
 * @var array $crumbs Breadcrumb items array with 'url' and 'text' keys
 */?>
<html lang="en">
<head>
<title><?php echo $pageTitle; ?></title>
<meta name="description" content="<?php echo $pageDescription; ?>">
<?php
// If canonical URL is specified, include canonical link element
if($pageCanonical)
{
    echo '<link rel="canonical" href="' . $pageCanonical . '">';
}
// If meta robots content is specified, include robots meta tag
if($pageRobots)
{
    echo '<meta name="robots" content="' . $pageRobots . '">';
}
?>

<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="wrapper">





    <?php \App\Core\BreadCrumbs::run(); if (!empty($crumbs)) { ?>
        <section id="inner-headline">
            <div class="row">
                <div class="col-lg-12">
                    <ul class="breadcrumb">
                        <?php foreach ($crumbs as $item) { ?>
                            <?php if (isset($item)) { ?>
                                <li>
                                    <?php if (!empty($item['url'])) { ?>
                                        <a href="<?php echo $item['url'] ?>"><?php echo $item['text'] ?></a>
                                    <?php } else { ?>
                                        <?php echo $item['text'] ?>
                                    <?php } ?>
                                </li>
                            <?php } ?>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </section>
    <?php } ?>

    <div class="breadcrumbs">
        <ol class="breadcrumb">
            <li><a href="/admin">Admin Panel</a></li>
            <li><a href="/admin/order">Order Management</a></li>
            <li class="active">Edit Order</li>
        </ol>
    </div>
