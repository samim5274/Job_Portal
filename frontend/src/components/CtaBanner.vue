<template>
    <section class="w-full bg-white">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-10">
            <div class="relative overflow-hidden rounded-2xl bg-white border border-[#EEF0FF]">
                <!-- Purple background with angled corners -->
                <div class="absolute inset-0 bg-[#4640DE] [clip-path:polygon(0_0,92%_0,100%_14%,100%_100%,8%_100%,0_86%)]"></div>

                <div class="relative grid gap-8 lg:grid-cols-2 lg:items-center p-6 sm:p-10 lg:p-12">
                    <!-- Left content -->
                    <div class="text-white">
                        <h3 class="text-2xl sm:text-3xl font-extrabold leading-tight">
                            Start posting<br />
                            jobs today
                        </h3>

                        <p class="mt-3 text-sm text-white/80 max-w-sm">Start posting jobs for only $10.</p>

                        <a href="#signup" class="mt-6 inline-flex items-center justify-center rounded-md bg-white px-5 py-2.5 text-sm font-semibold text-[#4640DE] shadow-sm hover:opacity-95 transition">Sign Up For Free</a>
                    </div>

                    <!-- Right image -->
                    <div class="relative">
                        <div class="relative ml-auto w-full max-w-[560px]">
                            <img :src="dashboardImg" alt="Dashboard preview" class="w-full rounded-xl shadow-[0_30px_80px_-55px_rgba(0,0,0,0.6)]"/>
                            <div class="pointer-events-none absolute -bottom-6 left-0 right-0 h-10 bg-white/80 blur-[1px] opacity-0 lg:opacity-100"></div>
                        </div>
                    </div>
                </div>

                <div class="relative h-6 bg-white"></div>
            </div>
        </div>
    </section>
</template>

<script setup>
const dashboardImg = new URL("../assets/dashboard.png", import.meta.url).href;
</script>

<style>

</style>