<template>
    <section class="relative overflow-hidden bg-[#F7F7FF]">
        <!-- background diagonal line accents -->
        <div class="pointer-events-none absolute inset-0">
            <div class="absolute -right-24 -top-24 h-[520px] w-[520px] rotate-12 border-2 border-[#d8d9fc] opacity-60"></div>
            <div class="absolute -right-10 top-40 h-[520px] w-[520px] rotate-12 border-2 border-[#dddeff] opacity-40"></div>
            <div class="absolute -left-40 bottom-[-220px] h-[560px] w-[560px] rotate-12 border-2 border-[#dbdcff] opacity-40"></div>
        </div>

        <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-10 lg:py-12">
            <!-- Header -->
            <div class="flex items-center justify-between gap-4">
                <h2 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-[#1F2345]">
                    Latest <span class="text-[#2F8CFF]">jobs</span> open
                </h2>

                <a @click="ShowAllJobs" class="inline-flex items-center gap-2 text-sm font-semibold text-[#4640DE] hover:opacity-90">
                    Show all jobs <span aria-hidden="true">→</span>
                </a>
            </div>

            <!-- Grid -->
            <div class="mt-8 grid gap-5 lg:grid-cols-2">
                <!-- Left column -->
                <div class="grid gap-4">
                    <article v-for="job in leftJobs" :key="job.id" class="rounded-lg border border-[#EEF0FF] bg-white px-5 py-4 shadow-[0_14px_50px_-40px_rgba(31,35,69,0.45)] hover:shadow-[0_20px_60px_-45px_rgba(31,35,69,0.55)] transition">
                        <div class="flex items-start gap-4">
                            <!-- logo -->
                            <div
                                class="h-11 w-11 rounded-full flex items-center justify-center font-extrabold"
                                :style="{ backgroundColor: job.logoBg, color: job.logoColor }">
                                <i v-if="job.logoIcon" :class="[job.logoIcon, 'text-base']"></i>
                                <span v-else>{{ job.company.slice(0, 1) }}</span>
                            </div>
                            <!-- content -->
                            <div class="min-w-0 flex-1">
                                <h3 class="truncate text-sm font-extrabold text-[#1F2345]">{{ job.title }}</h3>
                                <p class="mt-1 text-[11px] text-[#6B7280]">{{ job.company }} • {{ job.location }}</p>

                                <!-- pills -->
                                <div class="mt-3 flex flex-wrap gap-2">
                                    <span class="rounded-full border border-emerald-100 bg-emerald-50 px-3 py-1 text-[11px] font-semibold text-emerald-700">
                                        {{ job.badgeType }}
                                    </span>
                                    <span v-for="t in job.tags" :key="t" class="rounded-full border px-3 py-1 text-[11px] font-semibold" :class="pillClass(t)">
                                        {{ t }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </article>
                </div>

                <!-- Right column -->
                <div class="grid gap-4">
                    <article v-for="job in rightJobs" :key="job.id" class="rounded-lg border border-[#EEF0FF] bg-white px-5 py-4 shadow-[0_14px_50px_-40px_rgba(31,35,69,0.45)] hover:shadow-[0_20px_60px_-45px_rgba(31,35,69,0.55)] transition">
                        <div class="flex items-start gap-4">
                            <!-- logo -->
                            <div
                                class="h-11 w-11 rounded-full flex items-center justify-center font-extrabold"
                                :style="{ backgroundColor: job.logoBg, color: job.logoColor }">
                                <i v-if="job.logoIcon" :class="[job.logoIcon, 'text-base']"></i>
                                <span v-else>{{ job.company.slice(0, 1) }}</span>
                            </div>

                            <!-- content -->
                            <div class="min-w-0 flex-1">
                                <h3 class="truncate text-sm font-extrabold text-[#1F2345]">{{ job.title }}</h3>
                                <p class="mt-1 text-[11px] text-[#6B7280]">{{ job.company }} • {{ job.location }}</p>

                                <!-- pills -->
                                <div class="mt-3 flex flex-wrap gap-2">
                                    <span class="rounded-full border border-emerald-100 bg-emerald-50 px-3 py-1 text-[11px] font-semibold text-emerald-700">
                                        {{ job.badgeType }}
                                    </span>

                                    <span v-for="t in job.tags" :key="t" class="rounded-full border px-3 py-1 text-[11px] font-semibold" :class="pillClass(t)">
                                        {{ t }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </article>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import { useRouter } from "vue-router";

const router = useRouter();

async function ShowAllJobs() {
    router.push('/show-all-jobs')
}

const allJobs = [
    {
        id: 1,
        title: "Social Media Assistant",
        company: "Nomad",
        location: "Paris, France",
        logoBg: "#E8F5FF",
        logoColor: "#2F8CFF",
        logoIcon: "fa-solid fa-leaf",
        badgeType: "Full-Time",
        tags: ["Marketing", "Design"],
    },
    {
        id: 2,
        title: "Brand Designer",
        company: "Dropbox",
        location: "San Francisco, USA",
        logoBg: "#EAF1FF",
        logoColor: "#2563EB",
        logoIcon: "fa-brands fa-dropbox",
        badgeType: "Full-Time",
        tags: ["Marketing", "Design"],
    },
    {
        id: 3,
        title: "Interactive Developer",
        company: "Terraform",
        location: "Hamburg, Germany",
        logoBg: "#E7FBFF",
        logoColor: "#06B6D4",
        logoIcon: "fa-solid fa-cube",
        badgeType: "Full-Time",
        tags: ["Marketing", "Design"],
    },
    {
        id: 4,
        title: "HR Manager",
        company: "Packer",
        location: "Lucern, Switzerland",
        logoBg: "#FFEDEA",
        logoColor: "#F97316",
        logoIcon: "fa-solid fa-user-tie",
        badgeType: "Full-Time",
        tags: ["Marketing", "Design"],
    },
    {
        id: 5,
        title: "Social Media Assistant",
        company: "Netlify",
        location: "Paris, France",
        logoBg: "#E9FBF5",
        logoColor: "#10B981",
        logoIcon: "fa-solid fa-hashtag",
        badgeType: "Full-Time",
        tags: ["Marketing", "Design"],
    },
    {
        id: 6,
        title: "Brand Designer",
        company: "Maze",
        location: "San Francisco, USA",
        logoBg: "#EAF1FF",
        logoColor: "#2563EB",
        logoIcon: "fa-solid fa-infinity",
        badgeType: "Full-Time",
        tags: ["Marketing", "Design"],
    },
    {
        id: 7,
        title: "Interactive Developer",
        company: "Udacity",
        location: "Hamburg, Germany",
        logoBg: "#E7FBFF",
        logoColor: "#06B6D4",
        logoIcon: "fa-solid fa-graduation-cap",
        badgeType: "Full-Time",
        tags: ["Marketing", "Design"],
    },
    {
        id: 8,
        title: "HR Manager",
        company: "Webflow",
        location: "Lucern, Switzerland",
        logoBg: "#EEF2FF",
        logoColor: "#4F46E5",
        logoIcon: "fa-solid fa-wand-magic-sparkles",
        badgeType: "Full-Time",
        tags: ["Marketing", "Design"],
    },
];

const leftJobs = allJobs.slice(0, 4);
const rightJobs = allJobs.slice(4, 8);

function pillClass(tag) {
    if (tag === "Marketing") return "bg-amber-50 text-amber-700 border-amber-100";
    if (tag === "Design") return "bg-violet-50 text-violet-700 border-violet-100";
    return "bg-slate-100 text-slate-700 border-slate-200";
}
</script>