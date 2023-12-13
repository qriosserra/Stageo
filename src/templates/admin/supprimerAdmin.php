<?php
/**
 * @var ArrayObject $admins
 * @var \Stageo\Model\Object\Admin $admin
 */

use Stageo\Lib\enums\Action;

?>
<div class="bg-gray-100 h-screen flex justify-center items-center p-12">

<div class="w-full max-w-4xl">
    <table class="min-w-full table-auto bg-white rounded-lg shadow-md overflow-hidden">
        <thead class="bg-gray-200">
            <tr>
                <th class="px-4 py-2 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Login</th>
                <th class="px-4 py-2 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-white">
            <?php foreach ($admins as $admin) : ?>
                <tr>
                    <td class="px-4 py-3 border-b border-gray-200 text-sm text-gray-700"><?= $admin->getLogin() ?></td>
                    <td class="px-4 py-3 border-b border-gray-200 text-sm text-gray-700">
                        <a href="<?= Action::ADMIN_SUPRIMERADMIN->value."&login=".$admin->getLogin() ?>"
                           class="text-white bg-red-500 hover:bg-red-700 rounded px-4 py-1">
                            Révoquer
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

            </div>