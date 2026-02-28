<template>
    <section class="w-full bg-white">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-10 lg:py-12">
            <!-- Header -->
            <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <button class="inline-flex items-center gap-2 rounded-lg px-3 py-2 text-sm font-semibold text-indigo-600 hover:bg-indigo-50 focus:outline-none focus:ring-2 focus:ring-indigo-500/30"
                        @click="router.back()">
                        <span aria-hidden="true">←</span> Back
                    </button>
                        
                    <h2 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-[#1F2345]">
                        All Jobs
                    </h2>
                    <p class="mt-1 text-sm text-slate-500">
                        Browse jobs by title, company, category, and location.
                    </p>
                </div>

                <!-- Search -->
                <div class="w-full sm:w-[360px]">
                    <div class="relative">
                        <input
                        v-model="q"
                        type="search"
                        placeholder="Search jobs, company, location..."
                        class="w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 pr-10 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"/>
                        <span class="absolute right-3 top-2.5 text-slate-400">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        </span>
                    </div>
                </div>
            </div>

            <!-- Filters -->
            <div class="mt-6 grid gap-3 sm:grid-cols-2 lg:grid-cols-4">
                <!-- Category -->
                <select
                    v-model="filters.category"
                    class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="">All Categories</option>
                    <option v-for="c in categories" :key="c.id" :value="String(c.id)">
                        {{ c.name }}
                    </option>
                </select>

                <!-- Type -->
                <select
                    v-model="filters.type"
                    class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="">All Types</option>
                    <option value="full_time">Full Time</option>
                    <option value="part_time">Part Time</option>
                    <option value="contract">Contract</option>
                    <option value="internship">Internship</option>
                    <option value="remote">Remote</option>
                </select>

                <!-- Location -->
                <input
                    v-model="filters.location"
                    type="text"
                    placeholder="Location (e.g., Dhaka)"
                    class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"/>

                <!-- Sort -->
                <select
                    v-model="sortBy"
                    class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="newest">Newest</option>
                    <option value="oldest">Oldest</option>
                    <option value="title_asc">Title A → Z</option>
                    <option value="title_desc">Title Z → A</option>
                </select>
            </div>

            <!-- Summary row -->
            <div class="mt-6 flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                <p class="text-sm text-slate-600">
                Showing
                <span class="font-semibold">{{ filteredJobs.length }}</span>
                jobs (Total:
                <span class="font-semibold">{{ total }}</span>)
                </p>

                <button
                type="button"
                @click="resetFilters"
                class="inline-flex items-center gap-2 text-sm font-semibold text-indigo-600 hover:opacity-90"
                >
                <i class="fa-solid fa-rotate-left"></i> Reset
                </button>
            </div>

            <!-- Loading -->
            <div v-if="loading" class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                <div v-for="i in 6" :key="i" class="rounded-xl border border-slate-200 bg-white p-5">
                <div class="h-10 w-10 rounded-lg bg-slate-100 animate-pulse"></div>
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

            <!-- Jobs grid -->
            <div v-else class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                <article
                v-for="job in filteredJobs"
                :key="job.id"
                @click="openJob(job)" @keydown.enter="openJob(job)"
                class="group relative rounded-xl border border-slate-200 bg-white p-5 transition hover:-translate-y-0.5 hover:shadow-[0_18px_50px_-38px_rgba(31,35,69,0.45)]">
                    <!-- badge -->
                    <div class="absolute right-4 top-4">
                        <span class="rounded-md bg-indigo-50 px-2.5 py-1 text-[11px] font-semibold text-indigo-600">
                        {{ displayType(job.type) }}
                        </span>
                    </div>

                    <!-- top -->
                    <div class="flex items-start gap-3 pr-16">
                        <div class="grid h-11 w-11 place-items-center rounded-xl bg-indigo-600 text-white ring-1 ring-black/5">
                            <i class="fa-solid fa-briefcase text-base"></i>
                        </div>

                        <div class="min-w-0">
                            <h3 class="truncate text-sm font-extrabold text-[#1F2345]">
                                {{ job.title ?? "Untitled Job" }}
                            </h3>
                            <p class="mt-1 text-[11px] text-slate-500">
                                {{ job.company ?? "Unknown Company" }} • {{ job.location ?? "Unknown Location" }}
                            </p>
                        </div>
                    </div>

                    <!-- desc -->
                    <p class="mt-4 text-[12px] leading-5 text-slate-500 line-clamp-2">
                        {{ job.description ?? "No description provided." }}
                    </p>

                    <!-- meta -->
                    <div class="mt-4 flex flex-wrap gap-2">
                        <span
                        v-if="job.category?.name"
                        class="rounded-lg bg-slate-100 px-2.5 py-1 text-[11px] font-semibold text-slate-700">
                            {{ job.category.name }}
                        </span>

                        <span
                        v-if="job.salary"
                        class="rounded-lg bg-emerald-50 px-2.5 py-1 text-[11px] font-semibold text-emerald-700">
                            {{ job.salary }}
                        </span>

                        <span
                        v-if="job.remote"
                        class="rounded-lg bg-violet-50 px-2.5 py-1 text-[11px] font-semibold text-violet-700">
                            Remote
                        </span>
                    </div>

                    <!-- actions -->
                    <div class="mt-5 flex items-center justify-between">
                        <span class="text-[11px] text-slate-400">
                            {{ job.created_at ? formatDate(job.created_at) : "Recently" }}
                        </span>

                        <button
                            type="button"
                            class="inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-3 py-2 text-xs font-semibold text-white hover:opacity-95 focus:outline-none focus:ring-2 focus:ring-indigo-500/30"
                            @click="openJob(job)">
                            View <span aria-hidden="true">→</span>
                        </button>
                    </div>
                </article>

                <p v-if="filteredJobs.length === 0" class="col-span-full mt-2 text-sm text-slate-500">
                No jobs found on this page.
                </p>
            </div>

            <!-- Pagination (server) -->
            <div v-if="!loading && !errorMsg && lastPage > 1" class="mt-8 flex items-center justify-center gap-2">
                <button
                    class="rounded-lg border border-slate-200 px-3 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50 disabled:opacity-50"
                    :disabled="page === 1"
                    @click="prevPage">
                    Prev
                </button>

                <span class="text-sm text-slate-600">
                    Page <span class="font-semibold">{{ page }}</span> / {{ lastPage }}
                </span>

                <button
                class="rounded-lg border border-slate-200 px-3 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50 disabled:opacity-50"
                :disabled="page === lastPage"
                @click="nextPage">
                    Next
                </button>
            </div>
        </div>
    </section>
</template>

<script setup>
import { onMounted, ref, computed, watch } from "vue";
import { useRouter } from "vue-router";
import api from "../../services/api";

const router = useRouter();

const loading = ref(false);
const errorMsg = ref("");

const jobs = ref([]);
const categories = ref([]);

const q = ref("");
const filters = ref({ category: "", type: "", location: "" });
const sortBy = ref("newest");

// server pagination
const page = ref(1);
const lastPage = ref(1);
const total = ref(0);

// --- helpers ---
function displayType(type) {
    const map = {
        full_time: "Full Time",
        part_time: "Part Time",
        contract: "Contract",
        internship: "Internship",
        remote: "Remote",
    };
    return map[type] ?? (type || "Job");
}

function formatDate(dateStr) {
    try {
        return new Date(dateStr).toLocaleDateString();
    } catch {
        return "Recently";
    }
}

function openJob(job) {
    router.push({ name: "job-details", params: { id: job.id } });
}

function resetFilters() {
    q.value = "";
    filters.value = { category: "", type: "", location: "" };
    sortBy.value = "newest";
    page.value = 1;
    fetchJobs();
}

// --- filtering on current page data ---
const filteredJobs = computed(() => {
    const query = q.value.trim().toLowerCase();
    let list = [...(jobs.value ?? [])];

    if (query) {
        list = list.filter((j) => {
        const catName = j.category?.name ?? "";
        const hay = `${j.title ?? ""} ${j.company ?? ""} ${j.location ?? ""} ${catName}`.toLowerCase();
        return hay.includes(query);
        });
    }

    if (filters.value.category) {
        list = list.filter((j) => String(j.category_id ?? j.category?.id) === String(filters.value.category));
    }

    if (filters.value.type) {
        list = list.filter((j) => (j.type ?? "") === filters.value.type);
    }

    if (filters.value.location) {
        const loc = filters.value.location.toLowerCase();
        list = list.filter((j) => (j.location ?? "").toLowerCase().includes(loc));
    }

    if (sortBy.value === "title_asc") list.sort((a, b) => (a.title ?? "").localeCompare(b.title ?? ""));
    if (sortBy.value === "title_desc") list.sort((a, b) => (b.title ?? "").localeCompare(a.title ?? ""));
    if (sortBy.value === "oldest") list.sort((a, b) => new Date(a.created_at ?? 0) - new Date(b.created_at ?? 0));
    if (sortBy.value === "newest") list.sort((a, b) => new Date(b.created_at ?? 0) - new Date(a.created_at ?? 0));

    return list;
});

// filters/search/sort change হলে ১ নম্বর পেজে গিয়ে আবার API কল
watch([q, filters, sortBy], () => {
    page.value = 1;
    fetchJobs();
});

// --- API calls ---
async function fetchJobs() {
    loading.value = true;
    errorMsg.value = "";
    try {
        const res = await api.get("/jobs", {
        params: {
            page: page.value,
            // future: send filters to backend
        },
        });

        const paginator = res.data?.data;
        jobs.value = paginator?.data ?? [];
        lastPage.value = paginator?.last_page ?? 1;
        total.value = paginator?.total ?? jobs.value.length;
    } catch (err) {
        console.error("jobs load error:", err);
        errorMsg.value = "Failed to load jobs.";
        jobs.value = [];
        lastPage.value = 1;
        total.value = 0;
    } finally {
        loading.value = false;
    }
}

async function fetchCategories() {
    try {
        const res = await api.get("/categories");
        categories.value = res.data?.data ?? [];
    } catch {
        categories.value = [];
    }
}

function nextPage() {
    if (page.value < lastPage.value) {
        page.value++;
        fetchJobs();
    }
}
function prevPage() {
    if (page.value > 1) {
        page.value--;
        fetchJobs();
    }
}

onMounted(() => {
    fetchJobs();
    fetchCategories();
});
</script>

<style scoped>
    .line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>