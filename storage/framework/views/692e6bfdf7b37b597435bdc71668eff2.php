

<?php $__env->startSection('title', 'user Login'); ?>

<?php $__env->startSection('content'); ?>
    <div class="min-h-screen flex">
        
        <div class="w-full lg:w-1/2 flex flex-col justify-center px-8 lg:px-24 bg-slate-950">
            <div class="max-w-md w-full mx-auto">
                <h2 class="text-3xl font-bold text-white mb-2">Welcome Back</h2>
                <p class="text-slate-400 mb-8">Sign in to manage your shipments and track deliveries.</p>

                <?php if($errors->any()): ?>
                    <div class="bg-red-500/10 border border-red-500/50 text-red-400 p-4 rounded-lg mb-6 text-sm">
                        <?php echo e($errors->first()); ?>

                    </div>
                <?php endif; ?>

                <form action="<?php echo e(route('login')); ?>" method="POST" class="space-y-6">
                    <?php echo csrf_field(); ?>
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-1">Email Address</label>
                        <input type="email" name="email" value="<?php echo e(old('email')); ?>" required
                            class="w-full bg-slate-900 border border-slate-700 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500">
                    </div>

                    <div>
                        <div class="flex justify-between mb-1">
                            <label class="block text-sm font-medium text-slate-300">Password</label>
                            <a href="#" class="text-sm text-amber-500 hover:text-amber-400">Forgot Password?</a>
                        </div>
                        <div class="relative">
                            <input type="password" name="password" id="password" required
                                class="w-full bg-slate-900 border border-slate-700 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500">
                            <button type="button"
                                onclick="document.getElementById('password').type = document.getElementById('password').type === 'password' ? 'text' : 'password'"
                                class="absolute right-3 top-3 text-slate-400 hover:text-white">
                                <i class="ti ti-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" name="remember" id="remember"
                            class="rounded border-slate-700 bg-slate-900 text-amber-500 focus:ring-amber-500">
                        <label for="remember" class="ml-2 text-sm text-slate-300">Remember me</label>
                    </div>

                    <button type="submit"
                        class="w-full bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold py-3 px-4 rounded-lg transition duration-200">
                        Sign In
                    </button>
                </form>

                <p class="mt-8 text-center text-sm text-slate-400">
                    Don't have an account? <a href="<?php echo e(route('register')); ?>"
                        class="text-amber-500 hover:text-amber-400 font-medium">Register</a>
                </p>
            </div>
        </div>

        
        <div class="hidden lg:flex w-1/2 bg-slate-900 flex-col justify-center items-center p-12 relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-amber-500/10 to-transparent"></div>
            <div class="relative z-10 text-center max-w-lg">
                <div
                    class="inline-flex h-20 w-20 items-center justify-center rounded-2xl bg-amber-400 text-slate-950 font-black text-4xl mb-8 shadow-xl shadow-amber-500/20">
                    SS
                </div>
                <h3 class="text-4xl font-bold text-white mb-6">Logistics Made Simple</h3>
                <div class="space-y-4 text-left">
                    <div class="flex items-center space-x-3 text-slate-300">
                        <i class="ti ti-check text-amber-500 text-xl"></i>
                        <span>Real-time GPS tracking across 15+ carriers</span>
                    </div>
                    <div class="flex items-center space-x-3 text-slate-300">
                        <i class="ti ti-check text-amber-500 text-xl"></i>
                        <span>Instant dynamic fare calculation</span>
                    </div>
                    <div class="flex items-center space-x-3 text-slate-300">
                        <i class="ti ti-check text-amber-500 text-xl"></i>
                        <span>Reliable on-time delivery metrics</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Swift-Ship\resources\views/auth/customer-login.blade.php ENDPATH**/ ?>