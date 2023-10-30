<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">


    <title><?php echo e(config('app.name', 'Laravel')); ?></title>


    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet"/>


    <!-- Scripts -->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>
<body class="font-sans antialiased">
<div class="min-h-screen">
    <?php if(Route::has('login')): ?>
        <div class="p-6 text-right">
            <?php if(auth()->guard()->check()): ?>
                <?php echo $__env->make('layouts.navigation', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php else: ?>
                <a href="<?php echo e(route('login')); ?>"
                   class="font-semibold text-gray-600 hover:text-gray-900">Log
                    in</a>


                <?php if(Route::has('register')): ?>
                    <a href="<?php echo e(route('register')); ?>"
                       class="ml-4 font-semibold text-gray-600 hover:text-gray-900">Register</a>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    <?php endif; ?>


    <h2 class="m-6 text-xl font-semibold text-gray-900 text-center">Laravel Library App</h2>


    <table class="mx-auto">
        <thead>
        <tr>
            <th
                class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase border-b border-gray-200 bg-gray-50">
                #
            </th>
            <th
                class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase border-b border-gray-200 bg-gray-50">
                Title
            </th>
            <th
                class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase border-b border-gray-200 bg-gray-50">
                Author
            </th>
            <th
                class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase border-b border-gray-200 bg-gray-50">
                Release Year
            </th>
            <th
                class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase border-b border-gray-200 bg-gray-50">
                Released Copies
            </th>
            <th
                class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase border-b border-gray-200 bg-gray-50">
                Available Copies
            </th>
            <?php if(auth()->guard()->check()): ?>
                <th
                    class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase border-b border-gray-200 bg-gray-50">
                    Actions
                </th>
            <?php endif; ?>
        </tr>
        </thead>


        <tbody class="bg-white">
        <?php $__currentLoopData = $books; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $book): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200"><?php echo e($loop->index + 1); ?></td>
                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                    <div class="flex items-center">
                        <div class="text-sm font-medium leading-5 text-gray-900">
                            <?php echo e($book->title); ?>

                        </div>
                    </div>
                </td>


                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                    <div class="text-sm leading-5 text-gray-500"><?php echo e($book->author); ?></div>
                </td>


                <td
                    class="px-6 py-4 text-sm leading-5 text-gray-500 whitespace-no-wrap border-b border-gray-200">
                    <?php echo e($book->year); ?>

                </td>


                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                    <?php if($book->copies_in_circulation < 10): ?>
                        <span
                            class="inline-flex px-2 text-xs font-semibold leading-5 text-red-800 bg-red-100 rounded-full">
                                <?php echo e($book->copies_in_circulation); ?>

                            </span>
                    <?php elseif($book->copies_in_circulation < 20): ?>
                        <span
                            class="inline-flex px-2 text-xs font-semibold leading-5 text-orange-800 bg-orange-100 rounded-full">
                                <?php echo e($book->copies_in_circulation); ?>

                            </span>
                    <?php else: ?>
                        <span
                            class="inline-flex px-2 text-xs font-semibold leading-5 text-green-800 bg-green-100 rounded-full">
                                <?php echo e($book->copies_in_circulation); ?>

                            </span>
                    <?php endif; ?>
                </td>
                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                    <?php if($book->availableCopies() < 10): ?>
                        <span
                            class="inline-flex px-2 text-xs font-semibold leading-5 text-red-800 bg-red-100 rounded-full">
                                <?php echo e($book->availableCopies()); ?>

                            </span>
                    <?php elseif($book->availableCopies() < 20): ?>
                        <span
                            class="inline-flex px-2 text-xs font-semibold leading-5 text-orange-800 bg-orange-100 rounded-full">
                                <?php echo e($book->availableCopies()); ?>

                            </span>
                    <?php else: ?>
                        <span
                            class="inline-flex px-2 text-xs font-semibold leading-5 text-green-800 bg-green-100 rounded-full">
                                <?php echo e($book->availableCopies()); ?>

                            </span>
                    <?php endif; ?>
                </td>
                <?php if(auth()->guard()->check()): ?>
                    <td
                        class="px-6 py-4 text-sm leading-5 text-gray-500 whitespace-no-wrap border-b border-gray-200">
                    <?php if($book->canBeBorrowed()): ?>
                        <a href="<?php echo e(route('loans.create', ['book' => $book->id])); ?>">Borrow book</a>
                        <?php else: ?>
                        <p class="text-red-600"> No copies available to borrow</p>
                        <?php endif; ?>
                    </td>
                <?php endif; ?>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


        </tbody>
    </table>
</div>
</body>
</html><?php /**PATH C:\Users\acer\library-app\resources\views/books/index.blade.php ENDPATH**/ ?>