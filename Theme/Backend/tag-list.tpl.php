<?php
/**
 * Karaka
 *
 * PHP Version 8.1
 *
 * @package   Modules\Editor
 * @copyright Dennis Eichhorn
 * @license   OMS License 1.0
 * @version   1.0.0
 * @link      https://karaka.app
 */
declare(strict_types=1);

use phpOMS\Uri\UriFactory;

/**
 * @var \phpOMS\Views\View        $this
 * @var \Modules\Tag\Models\Tag[] $tags
 */
$tags = $this->getData('tags');

$previous = empty($tags) ? '{/lang}/{/app}/tag/list' : '{/lang}/{/app}/tag/list?{?}&id=' . \reset($tags)->getId() . '&ptype=p';
$next     = empty($tags) ? '{/lang}/{/app}/tag/list' : '{/lang}/{/app}/tag/list?{?}&id=' . \end($tags)->getId() . '&ptype=n';

echo $this->getData('nav')->render(); ?>
<div class="row">
    <div class="col-xs-12">
        <div class="portlet">
            <div class="portlet-head"><?= $this->getHtml('Tags'); ?><i class="fa fa-download floatRight download btn"></i></div>
            <div class="slider">
            <table class="default sticky">
            <thead>
            <tr>
                <td><?= $this->getHtml('Color'); ?>
                <td class="wf-100"><?= $this->getHtml('Title'); ?>
            <tbody>
            <?php $count = 0; foreach ($tags as $key => $value) : ++$count;
            $url         = UriFactory::build('{/lang}/{/app}/tag/single?{?}&id=' . $value->getId()); ?>
                <tr tabindex="0" data-href="<?= $url; ?>">
                    <td data-label="<?= $this->getHtml('Title'); ?>"><a href="<?= $url; ?>"><span class="tag" style="background: <?= $this->printHtml(\substr($value->color, 0, 7)); ?>">&nbsp;&nbsp;&nbsp;<?= $value->icon !== null ? '<i class="' . $this->printHtml($value->icon ?? '') . '"></i>' : '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'; ?>&nbsp;</span></a>
                    <td data-label="<?= $this->getHtml('Title'); ?>"><a href="<?= $url; ?>"><?= $this->printHtml($value->getL11n()); ?></a>

            <?php endforeach; ?>
            <?php if ($count === 0) : ?>
                <tr><td colspan="3" class="empty"><?= $this->getHtml('Empty', '0', '0'); ?>
            <?php endif; ?>
        </table>
        </div>
        <div class="portlet-foot">
            <a tabindex="0" class="button" href="<?= UriFactory::build($previous); ?>"><?= $this->getHtml('Previous', '0', '0'); ?></a>
            <a tabindex="0" class="button" href="<?= UriFactory::build($next); ?>"><?= $this->getHtml('Next', '0', '0'); ?></a>
        </div>
    </div>
</div>
