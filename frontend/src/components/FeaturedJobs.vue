<template>
    <section class="w-full bg-white">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-10 lg:py-12">

            <!-- Header (responsive) -->
            <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <h2 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-[#1F2345]">
                        Featured jobs
                    </h2>
                    <p class="mt-1 text-sm text-slate-500">
                        Latest opportunities picked for you.
                    </p>
                </div>

                <button
                    type="button"
                    @click="ShowAllJobs"
                    class="w-full sm:w-auto inline-flex items-center justify-center gap-2 rounded-lg px-4 py-2 text-sm font-semibold text-[#4640DE] hover:bg-[#F4F5FF] focus:outline-none focus:ring-2 focus:ring-[#4640DE]/30">
                    Show all jobs <span aria-hidden="true">→</span>
                </button>
            </div>

            <!-- Loading (responsive grid) -->
            <div v-if="loading" class="mt-8 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                <div v-for="i in 8" :key="i" class="rounded-xl border border-[#E7E8FF] bg-white p-5">
                <div class="h-11 w-11 rounded-full bg-slate-100 animate-pulse"></div>
                <div class="mt-4 h-4 w-2/3 rounded bg-slate-100 animate-pulse"></div>
                <div class="mt-3 h-3 w-1/2 rounded bg-slate-100 animate-pulse"></div>
                <div class="mt-5 flex gap-2">
                    <div class="h-6 w-16 rounded bg-slate-100 animate-pulse"></div>
                    <div class="h-6 w-20 rounded bg-slate-100 animate-pulse"></div>
                </div>
                </div>
            </div>

            <!-- Error -->
            <p v-else-if="errorMsg" class="mt-6 text-sm text-rose-600">
                {{ errorMsg }}
            </p>

            <!-- Grid (fully responsive) -->
            <div v-else class="mt-8 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                <article
                    v-for="job in jobs"
                    :key="job.id"
                    @click="openJob(job)"
                    @keydown.enter.prevent="openJob(job)"
                    class="group relative rounded-xl border border-[#E7E8FF] bg-white p-5 transition hover:-translate-y-0.5 hover:shadow-[0_18px_50px_-38px_rgba(31,35,69,0.45)]">
                    <!-- badge -->
                    <div class="absolute right-4 top-4">
                        <span class="rounded-md bg-[#F4F5FF] px-2.5 py-1 text-[11px] font-semibold text-[#4640DE]">
                        {{ job.type }}
                        </span>
                    </div>

                    <!-- top -->
                    <div class="flex items-start gap-3 pr-16">
                        <div
                        class="grid h-11 w-11 sm:h-12 sm:w-12 place-items-center rounded-full text-white ring-1 ring-black/5"
                        :style="{ backgroundColor: job.logoBg }">
                            <i :class="[safeIcon(job.logoIcon), 'text-base sm:text-lg']"></i>
                        </div>

                        <div class="min-w-0">
                            <h3 class="truncate text-sm sm:text-[15px] font-extrabold text-[#1F2345]">
                                {{ job.title }}
                            </h3>
                            <p class="mt-1 text-[11px] sm:text-[12px] text-[#6B7280] truncate">
                                {{ job.company }} • {{ job.location }}
                            </p>
                        </div>
                    </div>

                    <!-- desc -->
                    <p class="mt-4 text-[12px] sm:text-[13px] leading-5 text-[#6B7280] line-clamp-2">
                        {{ job.desc }}
                    </p>

                    <!-- tags -->
                    <div class="mt-4 flex flex-wrap gap-2">
                        <span
                        v-for="tag in job.tags"
                        :key="tag"
                        class="rounded-md px-2.5 py-1 text-[11px] font-semibold"
                        :class="tagClass(tag)"
                        >
                        {{ tag }}
                        </span>
                    </div>
                </article>

                <p v-if="jobs.length === 0" class="col-span-full mt-2 text-sm text-slate-500">
                No featured jobs found.
                </p>
            </div>
        </div>
    </section>
</template>

<script setup>
import { onMounted, ref } from "vue";
import api from "../services/api";
import { useRouter } from "vue-router";

const router = useRouter();

function ShowAllJobs() {
  router.push("/show-all-jobs");
}

const loading = ref(false);
const errorMsg = ref("");
const jobs = ref([]);

function safeIcon(icon) {
  return icon || "fa-solid fa-briefcase";
}

const jobIconMap = {
    "Laravel Developer": "fa-solid fa-code",
    "Vue.js Frontend Developer": "fa-solid fa-laptop-code",
    "UI/UX Designer": "fa-solid fa-pen-nib",
    "Digital Marketing Executive": "fa-solid fa-bullhorn",
    "Accounts Officer": "fa-solid fa-wallet",
    "HR Executive": "fa-solid fa-users-gear",
    "Customer Support Representative": "fa-solid fa-headset",
    "Civil Engineer": "fa-solid fa-helmet-safety",
};

function jobIcon(title) {
    return jobIconMap[title] || "fa-solid fa-briefcase";
}


function tagClass(tag) {
    const t = String(tag || "").toLowerCase();

    if (t.includes("marketing")) return "bg-amber-50 text-amber-700";
    if (t.includes("design")) return "bg-emerald-50 text-emerald-700";
    if (t.includes("business") || t.includes("hr") || t.includes("admin")) return "bg-violet-50 text-violet-700";
    if (t.includes("technology") || t.includes("it") || t.includes("software")) return "bg-rose-50 text-rose-700";
    if (t.includes("finance") || t.includes("accounts")) return "bg-sky-50 text-sky-700";
    if (t.includes("support")) return "bg-teal-50 text-teal-700";
    if (t.includes("engineering") || t.includes("civil")) return "bg-lime-50 text-lime-700";

    return "bg-slate-100 text-slate-700";
}


function mapJobToCard(job) {
    const catName = job.category?.name;

    return {
        id: job.id,
        type: job.type ?? "Full Time",
        title: job.title ?? "Untitled",
        company: job.company ?? "Unknown",
        location: job.location ?? "Unknown",
        desc: job.description ?? "",
        tags: job.tags ?? (catName ? [catName] : []),

        // Use title-based icon if backend doesn't send one
        logoIcon: job.logo_icon ?? jobIcon(job.title ?? ""),
        logoBg: job.logo_bg ?? "#4F46E5",
    };
}

async function fetchLatestJobs() {
    loading.value = true;
    errorMsg.value = "";

    try {
        const res = await api.get("/latest-jobs-8");
        const data = res.data?.data ?? [];
        jobs.value = data.map(mapJobToCard);
    } catch (err) {
        console.error("latest jobs load error:", err);
        errorMsg.value = "Failed to load jobs.";
        jobs.value = [];
    } finally {
        loading.value = false;
    }
}

function openJob(job) {
    router.push({ name: "job-details", params: { id: job.id } });
}

onMounted(fetchLatestJobs);
</script>

<style scoped>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>