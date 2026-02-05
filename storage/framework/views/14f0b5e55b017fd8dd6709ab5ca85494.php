
<?php $__env->startSection('title'); ?>
    My Todo App
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

    <div class="row mt-3">
        <div class="col-12 align-self-center">
            <ul class="list-group">
                <?php $__currentLoopData = $todos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $todo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li class="list-group-item"><a href="details" style="color: cornflowerblue"><?php echo e($todo->name); ?></a></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\todo\resources\views/index.blade.php ENDPATH**/ ?>