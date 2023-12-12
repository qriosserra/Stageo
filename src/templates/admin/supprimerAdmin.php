<?php
/**
 * @var ArrayObject $admins
 * @var \Stageo\Model\Object\Admin $admin
 */

use Stageo\Lib\enums\Action;

?>
<div class="h-screen mt-[8rem] p-12">
<?php foreach ($admins as $admin) : ?>
<a href="<?=Action::ADMIN_SUPRIMERADMIN->value."&login=".$admin->getLogin()?>"><?=$admin->getLogin()?></a>
<?php endforeach;?>
</div>
