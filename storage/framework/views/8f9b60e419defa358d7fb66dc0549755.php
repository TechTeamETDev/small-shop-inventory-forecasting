<h2>Edit User</h2>

<form method="POST" action="<?php echo e(route('users.update',$user->id)); ?>">
<?php echo csrf_field(); ?>
<?php echo method_field('PUT'); ?>

<input type="text" name="name" value="<?php echo e($user->name); ?>">

<input type="email" name="email" value="<?php echo e($user->email); ?>">

<select name="role">
<?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

<option value="<?php echo e($role->name); ?>"
<?php if($user->hasRole($role->name)): ?> selected <?php endif; ?>>

<?php echo e($role->name); ?>


</option>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</select>

<button type="submit">
Update
</button>

</form><?php /**PATH C:\Users\N Computer\Desktop\small-shop-inventory-forecasting\resources\views/users/edit.blade.php ENDPATH**/ ?>