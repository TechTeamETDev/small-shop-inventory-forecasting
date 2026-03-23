

<?php $__env->startSection('content'); ?>

<div class="max-w-5xl mx-auto py-10">

    <h1 class="text-2xl font-bold mb-6">Permission Debug Panel</h1>

    
    <div class="bg-white p-6 rounded shadow mb-6">
        <h2 class="font-bold text-lg mb-2">User Info</h2>
        <p><strong>Name:</strong> <?php echo e($user->name); ?></p>
        <p><strong>Email:</strong> <?php echo e($user->email); ?></p>
    </div>

    
    <div class="bg-white p-6 rounded shadow mb-6">
        <h2 class="font-bold text-lg mb-2">Roles</h2>

        <?php $__empty_1 = true; $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <span class="inline-block bg-blue-100 text-blue-800 px-3 py-1 rounded mr-2">
                <?php echo e($role->name); ?>

            </span>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <p class="text-red-500">No roles assigned ❌</p>
        <?php endif; ?>
    </div>

    
    <div class="bg-white p-6 rounded shadow mb-6">
        <h2 class="font-bold text-lg mb-2">User Permissions</h2>

        <?php $__empty_1 = true; $__currentLoopData = $permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $perm): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <span class="inline-block bg-green-100 text-green-800 px-3 py-1 rounded mr-2 mb-2">
                <?php echo e($perm->name); ?>

            </span>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <p class="text-red-500">No permissions ❌</p>
        <?php endif; ?>
    </div>

    
    <div class="bg-white p-6 rounded shadow">
        <h2 class="font-bold text-lg mb-2">All Permissions (DB)</h2>

        <?php $__currentLoopData = $allPermissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $perm): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="flex items-center justify-between border-b py-1">
                <span><?php echo e($perm->name); ?></span>

                <?php if($user->can($perm->name)): ?>
                    <span class="text-green-600 font-bold">✔ HAS</span>
                <?php else: ?>
                    <span class="text-red-600">✖ NO</span>
                <?php endif; ?>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\N Computer\Desktop\small-shop-inventory-forecasting\resources\views/debug/permissions.blade.php ENDPATH**/ ?>