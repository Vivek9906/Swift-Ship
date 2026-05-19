@extends('layouts.public')

@section('title', 'user Registration')

@section('content')
    <div class="min-h-screen flex" x-data="registerForm()">
        {{-- Left side (Form) --}}
        <div class="w-full lg:w-1/2 flex flex-col justify-center px-8 lg:px-24 bg-slate-950 py-12">
            <div class="max-w-md w-full mx-auto">
                <h2 class="text-3xl font-bold text-white mb-2">Create an Account</h2>
                <p class="text-slate-400 mb-8">Join SwiftShip to book and track your shipments easily.</p>

                <form action="{{ route('register') }}" method="POST" class="space-y-5" @submit="validateForm">
                    @csrf

                    {{-- Full Name --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-1">Full Name</label>
                        <input type="text" name="full_name" value="{{ old('full_name') }}" required
                            class="w-full bg-slate-900 border border-slate-700 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500">
                        @error('full_name') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Email --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-1">Email Address</label>
                        <input type="email" name="email" x-model="email" @input="checkEmail" required
                            class="w-full bg-slate-900 border border-slate-700 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500">
                        <p x-show="emailError" class="text-red-400 text-xs mt-1" x-text="emailError"></p>
                        @error('email') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Phone --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-1">Phone Number</label>
                        <div class="relative">
                            <span class="absolute left-4 top-3 text-slate-400">+91</span>
                            <input type="tel" name="phone" x-model="phone" @input="checkPhone" placeholder="9876543210"
                                required
                                class="w-full bg-slate-900 border border-slate-700 rounded-lg pl-12 pr-4 py-3 text-white focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500">
                        </div>
                        <p x-show="phoneError" class="text-red-400 text-xs mt-1" x-text="phoneError"></p>
                        @error('phone') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Password --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-1">Password</label>
                        <input type="password" name="password" x-model="password" @input="checkPassword" required
                            class="w-full bg-slate-900 border border-slate-700 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500">
                        <div class="h-1.5 w-full bg-slate-800 rounded-full mt-2 overflow-hidden flex">
                            <div class="h-full transition-all duration-300" :class="passwordStrengthColor"
                                :style="'width: ' + passwordStrength + '%'"></div>
                        </div>
                        <p class="text-xs mt-1" :class="passwordStrengthTextColor" x-text="passwordStrengthText"></p>
                        @error('password') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Confirm Password --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-1">Confirm Password</label>
                        <input type="password" name="password_confirmation" x-model="passwordConfirm" @input="checkMatch"
                            required
                            class="w-full bg-slate-900 border border-slate-700 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500">
                        <p x-show="matchError" class="text-red-400 text-xs mt-1" x-text="matchError"></p>
                    </div>

                    {{-- Terms --}}
                    <div class="flex items-start pt-2">
                        <input type="checkbox" name="terms" id="terms" required
                            class="mt-1 rounded border-slate-700 bg-slate-900 text-amber-500 focus:ring-amber-500">
                        <label for="terms" class="ml-2 text-sm text-slate-400">
                            I agree to the <a href="#" class="text-amber-500 hover:underline">Terms of Service</a> and <a
                                href="#" class="text-amber-500 hover:underline">Privacy Policy</a>
                        </label>
                    </div>
                    @error('terms') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror

                    <button type="submit" :disabled="!isFormValid"
                        :class="!isFormValid ? 'opacity-50 cursor-not-allowed' : 'hover:bg-amber-400'"
                        class="w-full bg-amber-500 text-slate-950 font-bold py-3 px-4 rounded-lg transition duration-200 mt-4">
                        Create Account
                    </button>
                </form>

                <p class="mt-8 text-center text-sm text-slate-400">
                    Already have an account? <a href="{{ route('login') }}"
                        class="text-amber-500 hover:text-amber-400 font-medium">Sign In</a>
                </p>
            </div>
        </div>

        {{-- Right side (Branding) --}}
        <div class="hidden lg:flex w-1/2 bg-slate-900 flex-col justify-center items-center p-12 relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-blue-500/10 to-transparent"></div>
            <div class="relative z-10 text-center max-w-lg">
                <div
                    class="inline-flex h-20 w-20 items-center justify-center rounded-2xl bg-amber-400 text-slate-950 font-black text-4xl mb-8 shadow-xl shadow-amber-500/20">
                    SS
                </div>
                <h3 class="text-4xl font-bold text-white mb-6">Join SwiftShip Today</h3>
                <p class="text-slate-300 text-lg mb-8 leading-relaxed">
                    Experience lightning-fast deliveries, transparent pricing, and real-time tracking across India.
                </p>
            </div>
        </div>
    </div>

    <script>
        function registerForm() {
            return {
                email: '{{ old("email") }}',
                phone: '{{ old("phone") }}',
                password: '',
                passwordConfirm: '',
                emailError: '',
                phoneError: '',
                matchError: '',
                passwordStrength: 0,
                passwordStrengthColor: 'bg-transparent',
                passwordStrengthText: '',
                passwordStrengthTextColor: 'text-transparent',

                checkEmail() {
                    if (!this.email) {
                        this.emailError = '';
                        return;
                    }
                    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    this.emailError = re.test(this.email) ? '' : 'Invalid email format';
                },
                checkPhone() {
                    if (!this.phone) {
                        this.phoneError = '';
                        return;
                    }
                    const cleanPhone = this.phone.replace('+91', '');
                    const re = /^[6-9]\d{9}$/;
                    this.phoneError = re.test(cleanPhone) ? '' : 'Enter a valid 10-digit mobile number';
                },
                checkPassword() {
                    if (!this.password) {
                        this.passwordStrength = 0;
                        this.passwordStrengthText = '';
                        return;
                    }

                    let score = 0;
                    if (this.password.length > 7) score += 33;
                    if (/[A-Z]/.test(this.password)) score += 33;
                    if (/\d/.test(this.password)) score += 34;

                    this.passwordStrength = score;

                    if (score <= 33) {
                        this.passwordStrengthColor = 'bg-red-500';
                        this.passwordStrengthText = 'Weak';
                        this.passwordStrengthTextColor = 'text-red-400';
                    } else if (score <= 66) {
                        this.passwordStrengthColor = 'bg-yellow-500';
                        this.passwordStrengthText = 'Medium';
                        this.passwordStrengthTextColor = 'text-yellow-400';
                    } else {
                        this.passwordStrengthColor = 'bg-green-500';
                        this.passwordStrengthText = 'Strong';
                        this.passwordStrengthTextColor = 'text-green-400';
                    }

                    this.checkMatch();
                },
                checkMatch() {
                    if (!this.passwordConfirm) {
                        this.matchError = '';
                        return;
                    }
                    this.matchError = this.password === this.passwordConfirm ? '' : 'Passwords do not match';
                },
                get isFormValid() {
                    return !this.emailError && !this.phoneError && !this.matchError &&
                        this.passwordStrength === 100 && this.email && this.phone &&
                        this.password && this.passwordConfirm;
                },
                validateForm(e) {
                    this.checkEmail();
                    this.checkPhone();
                    this.checkPassword();
                    this.checkMatch();

                    if (!this.isFormValid) {
                        e.preventDefault();
                    }
                }
            }
        }
    </script>
@endsection