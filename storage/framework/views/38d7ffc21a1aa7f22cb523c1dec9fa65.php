<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e(config('app.name', 'Laravel')); ?></title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>



    <script>
    const timeout = <?php echo e(auth()->check() && auth()->user()->hasRole('admin') ? 600 : 3600); ?>; // seconds
    const warningTime = 60; // 1 min warning

    let warningShown = false;

    function startTimer() {
        const warningDelay = (timeout - warningTime) * 1000;
        const logoutDelay = timeout * 1000;

        setTimeout(() => {
            warningShown = true;
            if (confirm("You will be logged out in 1 minute due to inactivity. Click OK to stay logged in.")) {
                extendSession();
            }
        }, warningDelay);

        setTimeout(() => {
            if (!warningShown) return;
            alert("You have been logged out due to inactivity.");
            window.location.href = '/logout';
        }, logoutDelay);
    }

    function extendSession() {
        fetch('/keep-alive', {
            method: 'POST',
            headers: {'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'}
        }).then(() => {
            warningShown = false;
            startTimer();
        });
    }

    startTimer();
</script>
</head>

<body class="font-sans antialiased bg-gray-100">

<div class="min-h-screen">

    <!-- Top Navigation -->
    <nav class="bg-white shadow px-6 py-4">
        <?php echo $__env->make('layouts.navigation', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </nav>

    <!-- Page Header (optional) -->
    <?php if(isset($header)): ?>
        <header class="bg-white shadow px-6 py-4">
            <?php echo e($header); ?>

        </header>
    <?php endif; ?>

    <!-- Page Content -->
    <main class="p-6">
        <?php echo $__env->yieldContent('content'); ?>  
        <?php echo $__env->yieldContent('scripts'); ?>
    </main>

</div>

</body>
</html><?php /**PATH C:\Users\N Computer\Desktop\small-shop-inventory-forecasting\resources\views/layouts/app.blade.php ENDPATH**/ ?>