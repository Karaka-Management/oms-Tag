<?php
/**
 * Jingga
 *
 * PHP Version 8.2
 *
 * @package   Modules\Editor
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.0
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

use phpOMS\Uri\UriFactory;

/** @var \phpOMS\Views\View $this */
echo $this->data['nav']->render(); ?>
<div class="row">
    <div class="col-xs-12 col-md-6">
        <div class="portlet">
            <form id="fUnitCreate" method="put" action="<?= UriFactory::build('{/api}tag?csrf={$CSRF}'); ?>">
                <div class="portlet-head"><?= $this->getHtml('Tag'); ?></div>
                <div class="portlet-body">
                    <div class="form-group">
                        <label for="iTitle"><?= $this->getHtml('Title'); ?></label>
                       <input type="text" name="title" id="iTitle" required>
                    </div>

                    <div class="form-group">
                       <label for="iColor"><?= $this->getHtml('Color'); ?></label>
                       <input type="color" name="color" id="iColor"required>
                    </div>

                    <div class="form-group">
                       <label for="iIcon"><?= $this->getHtml('Icon'); ?></label>
                       <input type="text" name="icon" id="iIcon" value="<?= $this->printHtml($tag->icon); ?>">
                    </div>
                </div>
                <div class="portlet-foot">
                    <input id="iSubmit" name="submit" type="submit" value="<?= $this->getHtml('Create', '0', '0'); ?>">
                </div>
            </form>
        </div>
    </div>
</div>