<h2>User Profile</h2>

<p><strong>Name:</strong> <?php echo e($user->name); ?></p>

<p><strong>Email:</strong> <?php echo e($user->email); ?></p>

<p><strong>Role:</strong>
<?php echo e($user->getRoleNames()->join(', ')); ?>

</p>

<a href="<?php echo e(route('users.index')); ?>">Back</a><?php /**PATH C:\Users\N Computer\Desktop\small-shop-inventory-forecasting\resources\views/users/show.blade.php ENDPATH**/ ?>