<template>
    <div class="min-h-screen bg-slate-50 text-slate-900">
        <!-- Top Nav -->
        <header class="sticky top-0 z-30 bg-[#F7F7FF]/80 backdrop-blur border-b border-[#E7E8FF]">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="h-16 flex items-center justify-between">
                    <!-- Left: Brand + Nav -->
                    <div class="flex items-center gap-10">
                        <!-- Brand -->
                        <a href="#" class="flex items-center gap-3">
                            <!-- Icon (circle like figma) -->
                            <span class="relative inline-flex h-10 w-10 items-center justify-center">
                                <span class="absolute inset-0 rounded-full bg-[#4640DE]"></span>
                                <span class="absolute inset-[6px] rounded-full bg-white/95"></span>
                                <span class="absolute inset-[12px] rounded-full bg-[#4640DE]"></span>
                            </span>

                            <span class="text-[15px] font-semibold text-[#1F2345]">QuickHire</span>
                        </a>

                        <!-- Desktop Nav -->
                        <nav class="hidden md:flex items-center gap-7 text-[14px] text-[#515B7E]">
                            <a @click="ShowAllJobs" class="hover:text-[#1F2345] transition">Find Jobs</a>
                            <a href="#companies" class="hover:text-[#1F2345] transition">Browse Companies</a>
                        </nav>
                    </div>

                    <!-- Right: Actions -->
                    <div class="flex items-center gap-4">
                        <!-- Desktop actions -->
                        <div class="hidden md:flex items-center">
                            <a @click="loginView" class="text-[14px] font-semibold text-[#4640DE] hover:opacity-90 transition">
                                Login
                            </a>

                            <span class="mx-5 h-7 w-px bg-[#E3E5FF]"></span>

                            <a @click="SignUp" class="inline-flex items-center justify-center rounded-md bg-[#4640DE] px-5 py-2.5 text-[14px] font-semibold text-white shadow-sm hover:opacity-95 transition">
                                Sign Up
                            </a>
                        </div>

                        <!-- Mobile menu button -->
                        <button
                            class="md:hidden inline-flex h-10 w-10 items-center justify-center rounded-lg hover:bg-white/70 transition"
                            @click="mobileOpen = !mobileOpen"
                            aria-label="Open menu">
                                <svg class="h-6 w-6 text-[#1F2345]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" d="M4 6h16M4 12h16M4 18h16" />
                                </svg>
                        </button>
                    </div>
                </div>

                <!-- Mobile dropdown -->
                <div v-if="mobileOpen" class="md:hidden pb-4">
                    <div class="mt-2 rounded-2xl border border-[#E7E8FF] bg-white shadow-sm overflow-hidden">
                        <div class="p-2 grid gap-1 text-[14px] text-[#515B7E]">
                            <a class="rounded-xl px-3 py-2 hover:bg-[#F4F5FF]" href="#jobs" @click="mobileOpen=false">
                                Find Jobs
                            </a>
                            <a class="rounded-xl px-3 py-2 hover:bg-[#F4F5FF]" href="#companies" @click="mobileOpen=false">
                                Browse Companies
                            </a>

                            <div class="my-2 h-px bg-[#EEF0FF]"></div>

                            <a class="rounded-xl px-3 py-2 font-semibold text-[#4640DE] hover:bg-[#F4F5FF]" @click="loginView">
                                Login
                            </a>
                            <a class="mt-1 rounded-xl px-3 py-2 font-semibold text-white bg-[#4640DE] hover:opacity-95 text-center" @click="SignUp">
                                Sign Up
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Hero -->
        <Hero />

        <!-- company -->
        <Company />

        <!-- Category -->
        <Category />

        <!-- CtaBanner -->
        <CtaBanner />

        <!-- FeaturedJobs -->
        <FeaturedJobs />

        <!-- LatestJobsOpen -->
        <LatestJobsOpen />

        <!-- Footer -->
        <Footer />
    </div>
</template>

<script setup>
import { ref } from "vue";
import { useRoute, useRouter } from "vue-router";

import Hero from "../components/hero-section.vue"
import Category from "../components/explore-category.vue"
import Company from "../components/company.vue"
import CtaBanner from "../components/CtaBanner.vue"
import FeaturedJobs from "../components/FeaturedJobs.vue"
import LatestJobsOpen from "../components/LatestJobsOpen.vue"
import Footer from "../components/Footer.vue"

const mobileOpen = ref(false);
const logoutLoading = ref(false);

const route = useRoute();
const router = useRouter();

async function ShowAllJobs() {
    router.push('/show-all-jobs')
}

async function loginView() {
    router.push("/login");
}

async function SignUp() {
    router.push("/register");
}

</script>