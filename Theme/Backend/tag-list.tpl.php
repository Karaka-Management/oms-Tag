<?php
/**
 * Jingga
 *
 * PHP Version 8.2
 *
 * @package   Modules\Editor
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.2
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

use phpOMS\Uri\UriFactory;

/**
 * @var \phpOMS\Views\View        $this
 * @var \Modules\Tag\Models\Tag[] $tags
 */
$previous = empty($tags) ? '{/base}/tag/list' : '{/base}/tag/list?{?}&offset=' . \reset($tags)->id . '&ptype=p';
$next     = empty($tags) ? '{/base}/tag/list' : '{/base}/tag/list?{?}&offset=' . \end($tags)->id . '&ptype=n';

echo $this->data['nav']->render(); ?>
<div class="row">
    <div class="col-xs-12">
        <section class="portlet">
            <div class="portlet-head"><?= $this->getHtml('Tags'); ?><i class="g-icon download btn end-xs">download</i></div>
            <div class="slider">
            <table class="default sticky">
            <thead>
            <tr>
                <td><?= $this->getHtml('Color'); ?>
                <td class="wf-100"><?= $this->getHtml('Title'); ?>
            <tbody>
            <?php $count = 0;
            foreach ($this->data['tags'] as $key => $value) : ++$count;
                $url = UriFactory::build('{/base}/tag/view?{?}&id=' . $value->id); ?>
                <tr tabindex="0" data-href="<?= $url; ?>">
                    <td data-label="<?= $this->getHtml('Title'); ?>"><a href="<?= $url; ?>"><span class="tag" style="background: <?= $this->printHtml(\substr($value->color, 0, 7)); ?>">&nbsp;&nbsp;&nbsp;<?= $value->icon !== null ? '<i class="g-icon">' . $this->printHtml($value->icon ?? '') . '</i>' : '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'; ?>&nbsp;</span></a>
                    <td data-label="<?= $this->getHtml('Title'); ?>"><a href="<?= $url; ?>"><?= $this->printHtml($value->getL11n()); ?></a>

            <?php endforeach; ?>
            <?php if ($count === 0) : ?>
                <tr><td colspan="3" class="empty"><?= $this->getHtml('Empty', '0', '0'); ?>
            <?php endif; ?>
            </table>
        </section>
        <div class="portlet-foot">
            <a tabindex="0" class="button" href="<?= UriFactory::build($previous); ?>"><?= $this->getHtml('Previous', '0', '0'); ?></a>
            <a tabindex="0" class="button" href="<?= UriFactory::build($next); ?>"><?= $this->getHtml('Next', '0', '0'); ?></a>
        </div>
    </div>
</div>
