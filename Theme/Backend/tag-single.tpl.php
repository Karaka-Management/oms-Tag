<?php
/**
 * Orange Management
 *
 * PHP Version 8.0
 *
 * @package   Modules\Editor
 * @copyright Dennis Eichhorn
 * @license   OMS License 1.0
 * @version   1.0.0
 * @link      https://orange-management.org
 */
declare(strict_types=1);

use phpOMS\Localization\ISO639Enum;
use phpOMS\Uri\UriFactory;

/** @var \Modules\Tag\Models\Tag */
$tag  = $this->getData('tag');
$l11n = $this->getData('l11n') ?? [];

/** @var \phpOMS\Views\View $this */
echo $this->getData('nav')->render(); ?>
<div class="row">
    <div class="col-xs-12 col-md-6">
        <div class="portlet">
            <form id="fTagUpdate" method="post" action="<?= UriFactory::build('{/api}tag'); ?>">
                <div class="portlet-head"><?= $this->getHtml('Tag'); ?></div>
                <div class="portlet-body">
                    <table class="layout wf-100" style="table-layout: fixed">
                        <tr><td><label for="iTitle"><?= $this->getHtml('Title'); ?></label>
                        <tr><td><input type="text" name="title" id="iTitle" placeholder="&#xf040; oms" value="<?= $this->printHtml($tag->getL11n()); ?>" required>
                        <tr><td><label for="iColor"><?= $this->getHtml('Color'); ?></label>
                        <tr><td><input type="color" name="color" id="iColor" value="<?= $this->printHtml(\substr($tag->color, 0, 7)); ?>" required>
                        <tr><td><label for="iIcon"><?= $this->getHtml('Icon'); ?></label>
                        <tr><td><input type="text" name="icon" id="iIcon" placeholder="&#xf040; oms" value="<?= $this->printHtml($tag->icon ?? ''); ?>">
                    </table>
                </div>
                <div class="portlet-foot">
                    <input type="hidden" name="id" value="<?= $tag->getId(); ?>">
                    <input id="iSubmit" name="submit" type="submit" value="<?= $this->getHtml('Save', '0', '0'); ?>">
                </div>
            </form>
        </div>
    </div>

    <div class="col-xs-12 col-md-6">
        <div class="portlet">
            <div class="portlet-head"><?= $this->getHtml('Language', '0', '0'); ?><i class="fa fa-download floatRight download btn"></i></div>
            <table class="default">
                <thead>
                    <tr>
                        <td>
                        <td>
                        <td><?= $this->getHtml('Language', '0', '0'); ?>
                        <td class="wf-100"><?= $this->getHtml('Title'); ?>
                <tbody>
                    <?php $c = 0; foreach ($l11n as $key => $value) : ++$c; ?>
                    <tr>
                        <td><a href="#"><i class="fa fa-times"></i></a>
                        <td><a href="#"><i class="fa fa-cogs"></i></a>
                        <td><?= ISO639Enum::getByName('_' . \strtoupper($value->getLanguage())); ?>
                        <td><?= $value->title; ?>
                    <?php endforeach; ?>
                    <?php if ($c === 0) : ?>
                    <tr><td colspan="3" class="empty"><?= $this->getHtml('Empty', '0', '0'); ?>
                    <?php endif; ?>
            </table>
        </div>
</div>