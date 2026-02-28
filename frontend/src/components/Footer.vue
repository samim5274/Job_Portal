<template>
    <footer class="bg-[#1F2335] text-white">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 pt-12 pb-6">
            <!-- Top grid -->
            <div class="grid gap-10 sm:gap-8 lg:grid-cols-4">
                <!-- Brand -->
                <div>
                    <div class="flex items-center gap-3">
                        <!-- logo circle -->
                        <span class="relative inline-flex h-9 w-9 items-center justify-center">
                            <span class="absolute inset-0 rounded-full bg-[#4640DE]"></span>
                            <span class="absolute inset-[6px] rounded-full bg-white/95"></span>
                            <span class="absolute inset-[12px] rounded-full bg-[#4640DE]"></span>
                        </span>
                        <span class="text-[15px] font-semibold">QuickHire</span>
                    </div>

                    <p class="mt-5 max-w-sm text-[12px] leading-6 text-white/60">
                        Great platform for the job seeker that passionate about startups.
                        Find your dream job easier.
                    </p>
                </div>

                <!-- About + Resources -->
                <div class="grid grid-cols-2 gap-10 sm:gap-12 lg:col-span-2">
                    <!-- About -->
                    <div>
                        <h4 class="text-sm font-semibold text-white/90">About</h4>
                        <ul class="mt-4 space-y-3 text-[12px] text-white/60">
                            <li><a class="hover:text-white transition" href="#companies">Companies</a></li>
                            <li><a class="hover:text-white transition" href="#pricing">Pricing</a></li>
                            <li><a class="hover:text-white transition" href="#terms">Terms</a></li>
                            <li><a class="hover:text-white transition" href="#advice">Advice</a></li>
                            <li><a class="hover:text-white transition" href="#privacy">Privacy Policy</a></li>
                        </ul>
                    </div>

                    <!-- Resources -->
                    <div>
                        <h4 class="text-sm font-semibold text-white/90">Resources</h4>
                        <ul class="mt-4 space-y-3 text-[12px] text-white/60">
                            <li><a class="hover:text-white transition" href="#help">Help Docs</a></li>
                            <li><a class="hover:text-white transition" href="#guide">Guide</a></li>
                            <li><a class="hover:text-white transition" href="#updates">Updates</a></li>
                            <li><a class="hover:text-white transition" href="#contact">Contact Us</a></li>
                        </ul>
                    </div>
                </div>

                <!-- Newsletter -->
                <div>
                    <h4 class="text-sm font-semibold text-white/90">Get job notifications</h4>
                    <p class="mt-4 text-[12px] leading-6 text-white/60">
                        The latest job news, articles, sent to your inbox weekly.
                    </p>

                    <form class="mt-5 flex w-full max-w-sm overflow-hidden rounded-md bg-white">
                        <input type="email" placeholder="Email Address" class="w-full px-4 py-3 text-sm text-slate-900 outline-none placeholder:text-slate-400"/>
                        <button type="button" class="bg-[#4640DE] px-6 text-sm font-semibold text-white hover:opacity-95 transition">Subscribe</button>
                    </form>
                </div>
            </div>

            <!-- Divider -->
            <div class="mt-10 border-t border-white/10"></div>

            <!-- Bottom -->
            <div class="mt-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <p class="text-[12px] text-white/50">
                    2021 © QuickHire. All rights reserved.
                </p>

                <!-- Social -->
                <div class="flex items-center gap-3">
                    <a class="grid h-9 w-9 place-items-center rounded-full bg-white/10 hover:bg-white/15 transition" href="#" aria-label="Facebook">
                        <i class="fa-brands fa-facebook-f text-[14px] text-white/80"></i>
                    </a>
                    <a class="grid h-9 w-9 place-items-center rounded-full bg-white/10 hover:bg-white/15 transition" href="#" aria-label="Instagram">
                        <i class="fa-brands fa-instagram text-[14px] text-white/80"></i>
                    </a>
                    <a class="grid h-9 w-9 place-items-center rounded-full bg-white/10 hover:bg-white/15 transition" href="#" aria-label="Dribbble">
                        <i class="fa-brands fa-dribbble text-[14px] text-white/80"></i>
                    </a>
                    <a class="grid h-9 w-9 place-items-center rounded-full bg-white/10 hover:bg-white/15 transition" href="#" aria-label="LinkedIn">
                        <i class="fa-brands fa-linkedin-in text-[14px] text-white/80"></i>
                    </a>
                    <a class="grid h-9 w-9 place-items-center rounded-full bg-white/10 hover:bg-white/15 transition" href="#" aria-label="Twitter">
                        <i class="fa-brands fa-x-twitter text-[14px] text-white/80"></i>
                    </a>
                </div>
            </div>
        </div>
    </footer>
</template>