<?php $__env->startSection('content'); ?>

<div class="container mx-auto p-6">

<?php if(session('success')): ?>
<div class="bg-green-200 text-green-800 p-3 mb-4">
    <?php echo e(session('success')); ?>

</div>
<?php endif; ?>


<h2 class="text-xl font-bold mb-4">Create New User</h2>

<form method="POST" action="<?php echo e(route('users.store')); ?>" class="mb-8 border p-4">
<?php echo csrf_field(); ?>

<div class="mb-3">
<label>Name</label>
<input type="text" name="name" class="border p-2 w-full" required>
</div>

<div class="mb-3">
<label>Email</label>
<input type="email" name="email" class="border p-2 w-full" required>
</div>

<div class="mb-3">
<label>Role</label>
<select name="role" class="border p-2 w-full">

<?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<option value="<?php echo e($role->name); ?>">
<?php echo e($role->name); ?>

</option>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

</select>
</div>

<button type="submit" class="bg-blue-600 text-white px-4 py-2">
Create User
</button>

</form>



<h2 class="text-xl font-bold mb-4">User List</h2>

<table class="table-auto w-full border">

<thead class="bg-gray-200">
<tr>

<th class="border px-3 py-2">Name</th>
<th class="border px-3 py-2">Email</th>
<th class="border px-3 py-2">Role</th>
<th class="border px-3 py-2">Status</th>
<th class="border px-3 py-2">Actions</th>

</tr>
</thead>


<tbody>

<?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

<tr>

<td class="border px-3 py-2">
<?php echo e($user->name); ?>

</td>

<td class="border px-3 py-2">
<?php echo e($user->email); ?>

</td>

<td class="border px-3 py-2">
<?php echo e($user->getRoleNames()->join(', ') ?: 'No Role'); ?>

</td>

<td class="border px-3 py-2">

<?php if($user->must_reset_password): ?>

<span class="text-yellow-600 font-semibold">
Password Reset Required
</span>

<?php else: ?>

<span class="text-green-600 font-semibold">
Active
</span>

<?php endif; ?>

</td>


<td class="border px-3 py-2 flex gap-2">

<a href="<?php echo e(route('users.show',$user->id)); ?>" class="text-blue-600">
👤 View
</a>

<a href="<?php echo e(route('users.edit',$user->id)); ?>" class="text-yellow-600">
✏ Edit
</a>


<form action="<?php echo e(route('users.destroy',$user->id)); ?>" method="POST">
<?php echo csrf_field(); ?>
<?php echo method_field('DELETE'); ?>

<button class="text-red-600">
🗑 Delete
</button>

</form>


<form action="<?php echo e(route('users.reset',$user->id)); ?>" method="POST">
<?php echo csrf_field(); ?>

<button class="text-purple-600">
🔑 Reset
</button>

</form>

</td>

</tr>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

</tbody>

</table>
<div class="mt-4">
<?php echo e($users->links()); ?>

</div>


</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\N Computer\Desktop\small-shop-inventory-forecasting\resources\views/users/index.blade.php ENDPATH**/ ?>