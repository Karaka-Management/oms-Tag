<?php
/**
 * Karaka
 *
 * PHP Version 8.0
 *
 * @package   Modules\Editor
 * @copyright Dennis Eichhorn
 * @license   OMS License 1.0
 * @version   1.0.0
 * @link      https://karaka.app
 */
declare(strict_types=1);

use phpOMS\Uri\UriFactory;

/** @var \phpOMS\Views\View $this */
echo $this->getData('nav')->render(); ?>
<div class="row">
    <div class="col-xs-12 col-md-6">
        <div class="portlet">
            <form id="fUnitCreate" method="put" action="<?= UriFactory::build('{/api}tag'); ?>">
                <div class="portlet-head"><?= $this->getHtml('Tag'); ?></div>
                <div class="portlet-body">
                    <table class="layout wf-100" style="table-layout: fixed">
                        <tr><td><label for="iTitle"><?= $this->getHtml('Title'); ?></label>
                        <tr><td><input type="text" name="title" id="iTitle" placeholder="&#xf040; oms" required>
                        <tr><td><label for="iColor"><?= $this->getHtml('Color'); ?></label>
                        <tr><td><input type="color" name="color" id="iColor"required>
                        <tr><td><label for="iIcon"><?= $this->getHtml('Icon'); ?></label>
                        <tr><td><input type="text" name="icon" id="iIcon" placeholder="&#xf040; oms" value="<?= $this->printHtml($tag->icon ?? ''); ?>">
                    </table>
                </div>
                <div class="portlet-foot">
                    <input id="iSubmit" name="submit" type="submit" value="<?= $this->getHtml('Create', '0', '0'); ?>">
                </div>
            </form>
        </div>
    </div>
</div>