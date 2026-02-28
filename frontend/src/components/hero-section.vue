<template>
    <section class="relative overflow-hidden bg-[#F7F7FF]">
        <!-- faint geometric lines background -->
        <div class="pointer-events-none absolute inset-0">
            <svg class="absolute right-0 top-0 h-full w-[55%] opacity-60" viewBox="0 0 900 600" fill="none">
                <path d="M600 40 L860 180 L860 520 L600 380 Z" stroke="#CFCBFF" stroke-width="3" />
                <path d="M520 90 L820 260 L820 560 L520 390 Z" stroke="#DAD7FF" stroke-width="3" />
                <path d="M680 10 L900 130 L900 460 L680 340 Z" stroke="#DAD7FF" stroke-width="3" />
            </svg>
        </div>

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 pt-10 pb-14 lg:pt-16 lg:pb-20">
            <div class="grid gap-10 lg:grid-cols-2 lg:items-center">
                <!-- LEFT -->
                <div class="relative z-10">
                    <h1 class="text-[#1F2345] font-extrabold leading-[1.05] text-4xl sm:text-5xl lg:text-[64px]">
                        Discover<br />
                        more than<br />
                        <span class="relative inline-block text-[#2F8CFF]">
                            5000+ Jobs
                            <!-- underline stroke -->
                            <span class="pointer-events-none absolute left-0 -bottom-3 h-[10px] w-full">
                                <svg viewBox="0 0 300 18" class="h-full w-full" fill="none">
                                <path
                                    d="M4 14 C60 8, 120 18, 190 10 C230 6, 260 8, 296 6"
                                    stroke="#2F8CFF"
                                    stroke-width="6"
                                    stroke-linecap="round"/>
                                </svg>
                            </span>
                        </span>
                    </h1>

                    <p class="mt-8 max-w-xl text-[15px] leading-7 text-[#6B7280]">
                        Great platform for the job seeker that searching for new career heights and passionate about startups.
                    </p>

                <!-- Search bar -->
                <div class="mt-8 w-full max-w-2xl rounded-md bg-white shadow-[0_20px_60px_-30px_rgba(31,35,69,0.35)]">
                    <div class="flex flex-col sm:flex-row sm:items-stretch">
                    <!-- keyword -->
                    <div class="flex items-center gap-3 px-5 py-4 sm:flex-1">                        
                        <i class="fa-solid fa-magnifying-glass h-5 w-5 text-[#9CA3AF]"></i>

                        <input v-model="filters.keyword" class="w-full text-sm outline-none placeholder:text-[#B6B9C7]" placeholder="Job title or keyword"/>
                    </div>

                    <!-- divider -->
                    <div class="hidden sm:block w-px bg-[#EEF0FF]"></div>

                        <!-- location -->
                        <div class="flex items-center gap-3 px-5 py-4 sm:w-[260px]">                        
                            <i class="fa-solid fa-location-dot h-5 w-5 text-[#9CA3AF]"></i>

                            <select v-model="filters.location" class="w-full bg-transparent text-sm outline-none text-[#515B7E]">
                                <option value="Florence, Italy">Florence, Italy</option>
                                <option value="Dhaka, BD">Dhaka, BD</option>
                                <option value="Remote">Remote</option>
                            </select>

                            <!-- <i class="fa-solid fa-chevron-down h-4 w-4 text-[#9CA3AF]"></i> -->
                        </div>

                        <!-- button -->
                        <button class="sm:m-2 rounded-none sm:rounded-md bg-[#4640DE] px-7 py-4 sm:py-0 text-sm font-semibold text-white hover:opacity-95 transition" @click="onSearch">
                            Search my job
                        </button>
                    </div>
                </div>

                <!-- Popular line -->
                <p class="mt-4 text-xs text-[#6B7280]">
                    Popular : <span class="text-[#515B7E]">UI Designer, UX Researcher, Android, Admin</span>
                </p>
                </div>

                <!-- RIGHT -->
                <div class="relative z-10">
                <div class="relative mx-auto max-w-[520px]">
                    <!-- photo -->
                    <img
                    class="relative z-10 w-full object-cover"
                    :src="heroImage"
                    alt="Hero"
                    />

                    <!-- bottom diagonal white cut -->
                    <div
                    class="pointer-events-none absolute -bottom-10 left-0 right-0 h-36 bg-white
                            [clip-path:polygon(0_70%,100%_15%,100%_100%,0_100%)]"
                    ></div>
                </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import { reactive } from "vue";

const filters = reactive({
    keyword: "",
    location: "Florence, Italy",
});

// iamge path
const heroImage = new URL("../assets/hero-man.png", import.meta.url).href;


// search
function onSearch() {
    console.log("Search:", { ...filters });
}

</script>

<style>

</style>