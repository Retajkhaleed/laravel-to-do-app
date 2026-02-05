
<?php $__env->startSection('title','Tasks'); ?>

<?php $__env->startSection('content'); ?>
  <div class="card">
    <div class="p">
      <form class="row" method="POST" action="<?php echo e(route('tasks.store')); ?>">
        <?php echo csrf_field(); ?>
        <input class="input" type="text" name="title" placeholder="Add a task..." value="<?php echo e(old('title')); ?>">
        <button class="btn btn-primary" type="submit">+ Add</button>
      </form>

      <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <div class="error"><?php echo e($message); ?></div>
      <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    <div class="divider"></div>

    <?php if($tasks->isEmpty()): ?>
      <div class="p muted">No tasks yet.</div>
    <?php else: ?>
      <?php $__currentLoopData = $tasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="task">
          <div class="dot <?php echo e($task->is_done ? 'done' : ''); ?>"></div>

          <div style="flex:1">
            <p class="title <?php echo e($task->is_done ? 'done' : ''); ?>"><?php echo e($task->title); ?></p>
            <div class="muted" style="font-size:12px;margin-top:6px">
              <?php echo e($task->created_at->format('Y-m-d H:i')); ?>

            </div>

            <form class="row" style="margin-top:10px" method="POST" action="<?php echo e(route('tasks.update', $task)); ?>">
              <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
              <input class="input" type="text" name="title" value="<?php echo e($task->title); ?>">
              <button class="btn" type="submit">Save</button>
            </form>
          </div>

          <div style="display:flex;gap:8px;flex-wrap:wrap;justify-content:flex-end">
            <form method="POST" action="<?php echo e(route('tasks.toggle', $task)); ?>">
              <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
              <button class="btn" type="submit"><?php echo e($task->is_done ? 'Undo' : 'Done'); ?></button>
            </form>

            <form method="POST" action="<?php echo e(route('tasks.destroy', $task)); ?>"
                  onsubmit="return confirm('Delete this task?')">
              <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
              <button class="btn btn-danger" type="submit">Delete</button>
            </form>
          </div>
        </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>
  </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('tasks.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\todo\resources\views/tasks/index.blade.php ENDPATH**/ ?>