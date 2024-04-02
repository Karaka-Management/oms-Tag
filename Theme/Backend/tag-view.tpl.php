<?php
/**
 * Jingga
 *
 * PHP Version 8.2
 *
 * @package   Modules\Tag
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.0
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

use Modules\Tag\Models\NullTag;
use phpOMS\Uri\UriFactory;

/** @var \Modules\Tag\Models\Tag */
$tag = $this->data['tag'] ?? new NullTag();

$isNew = $tag->id === 0;

/** @var \phpOMS\Views\View $this */
echo $this->data['nav']->render(); ?>
<div class="row">
    <div class="col-xs-12 col-md-6">
        <div class="portlet">
            <form id="tagForm" method="<?= $isNew ? 'PUT' : 'POST'; ?>" action="<?= UriFactory::build('{/api}tag?csrf={$CSRF}'); ?>"
                data-ui-container="#tagTable tbody"
                data-add-form="tagForm"
                data-add-tpl="#tagTable tbody .oms-add-tpl-tag">
                <div class="portlet-head"><?= $this->getHtml('Tag'); ?></div>
                <div class="portlet-body">
                    <div class="form-group">
                        <label for="iColor"><?= $this->getHtml('Color'); ?></label>
                        <input type="color" name="color" id="iColor" value="<?= $this->printHtml(\substr($tag->color, 0, 7)); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="iTitle"><?= $this->getHtml('Title'); ?></label>
                        <input type="text" id="iTitle" name="title" value="<?= $this->printHtml($tag->getL11n()); ?>"<?= $isNew ? ' required' : ' disabled'; ?>>
                    </div>

                    <div class="form-group">
                        <label for="iIcon"><?= $this->getHtml('Icon'); ?></label>
                        <input type="text" name="icon" id="iIcon" value="<?= $this->printHtml($tag->icon); ?>">
                    </div>
                </div>

                <div class="portlet-foot">
                    <input type="hidden" name="id" value="<?= $tag->id; ?>">
                    <input id="iSubmit" name="submit" type="submit" value="<?= $this->getHtml('Save', '0', '0'); ?>">
                </div>
            </form>
        </div>
    </div>
</div>

<?php if (!$isNew) : ?>
<div class="row">
    <?= $this->data['l11nView']->render(
        $this->data['l11nValues'],
        [],
        '{/api}tag/l11n?csrf={$CSRF}'
    );
    ?>
</div>
<?php endif; ?>