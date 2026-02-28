<template>
    <section class="w-full bg-white">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-10 lg:py-12">
            <!-- Header -->
            <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <div class="flex flex-wrap items-center gap-2">
                        <button
                        class="inline-flex items-center gap-2 rounded-lg px-3 py-2 text-sm font-semibold text-indigo-600 hover:bg-indigo-50 focus:outline-none focus:ring-2 focus:ring-indigo-500/30"
                        @click="router.back()"
                        type="button"
                        >
                        <span aria-hidden="true">←</span> Back
                        </button>

                        <RouterLink
                        class="inline-flex items-center gap-2 rounded-lg px-3 py-2 text-sm font-semibold text-indigo-600 hover:bg-indigo-50 focus:outline-none focus:ring-2 focus:ring-indigo-500/30"
                        to="/"
                        >
                        Home
                        </RouterLink>

                        <!-- Logout -->
                        <button
                        type="button"
                        @click="logout"
                        :disabled="logoutLoading"
                        class="inline-flex items-center gap-2 rounded-lg px-3 py-2 text-sm font-semibold
                                text-rose-600 hover:bg-rose-50 focus:outline-none focus:ring-2 focus:ring-rose-500/30
                                disabled:opacity-60 disabled:cursor-not-allowed"
                        >
                        <i v-if="!logoutLoading" class="fa-solid fa-right-from-bracket"></i>
                        <i v-else class="fa-solid fa-circle-notch fa-spin"></i>
                        {{ logoutLoading ? "Logging out..." : "Logout" }}
                        </button>
                    </div>

                    <h2 class="mt-4 text-2xl sm:text-3xl font-extrabold tracking-tight text-[#1F2345]">
                        All Jobs
                    </h2>
                    <p class="mt-1 text-sm text-slate-500">
                        Browse jobs by title, company, category, and location.
                    </p>
                </div>

                <!-- Right actions -->
                <div class="flex w-full flex-col gap-3 sm:w-auto sm:flex-row sm:items-center">
                <!-- Search -->
                    <div class="w-full sm:w-[360px]">
                        <div class="relative">
                            <input
                                v-model="q"
                                type="search"
                                placeholder="Search jobs, company, location..."
                                class="w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 pr-10 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            />
                            <span class="absolute right-3 top-2.5 text-slate-400">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </span>
                        </div>
                    </div>

                    <!-- Create (admin) -->
                    <button
                        type="button"
                        @click="openCreateModal"
                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white hover:opacity-95 focus:outline-none focus:ring-2 focus:ring-indigo-500/30">
                        <i class="fa-solid fa-plus"></i> Create Job
                    </button>
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

                <!-- Type (client side display only; if your backend has type then keep, otherwise ignore) -->
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
                class="inline-flex items-center gap-2 text-sm font-semibold text-indigo-600 hover:opacity-90">
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
                <article v-for="job in filteredJobs"
                    :key="job.id"
                    class="group relative rounded-xl border border-slate-200 bg-white p-5 transition hover:-translate-y-0.5 hover:shadow-[0_18px_50px_-38px_rgba(31,35,69,0.45)]"
                    tabindex="0"
                    @click="openJob(job)"
                    @keydown.enter="openJob(job)">

                    <!-- badge -->
                    <div class="absolute right-4 top-4 flex items-center gap-2">
                        <span class="rounded-md bg-indigo-50 px-2.5 py-1 text-[11px] font-semibold text-indigo-600">
                        {{ job.is_active ? "Active" : "Inactive" }}
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
                    </div>

                    <!-- actions -->
                    <div class="mt-5 flex items-center justify-between">
                        <span class="text-[11px] text-slate-400">
                            {{ job.created_at ? formatDate(job.created_at) : "Recently" }}
                        </span>

                        <div class="flex items-center gap-2">
                            <!-- View -->
                            <button
                                type="button"
                                class="inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-3 py-2 text-xs font-semibold text-white hover:opacity-95 focus:outline-none focus:ring-2 focus:ring-indigo-500/30"
                                @click.stop="openJob(job)">
                                View <span aria-hidden="true">→</span>
                            </button>

                            <!-- Delete (admin) -->
                            <button
                                type="button"
                                class="inline-flex items-center gap-2 rounded-lg bg-rose-50 px-3 py-2 text-xs font-semibold text-rose-700 ring-1 ring-rose-200 hover:bg-rose-100 focus:outline-none focus:ring-2 focus:ring-rose-500/30"
                                @click.stop="askDelete(job)">
                                <i class="fa-solid fa-trash"></i> Delete
                            </button>
                        </div>
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

        <!-- CREATE MODAL -->
        <div v-if="modalOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4" aria-modal="true" role="dialog">

            <div class="absolute inset-0 bg-black/50" @click="closeCreateModal"></div>

            <div class="relative w-full max-w-xl rounded-2xl bg-white shadow-xl">
                <div class="flex items-center justify-between border-b border-slate-200 px-5 py-4">
                    <h3 class="text-lg font-extrabold text-[#1F2345]">Create Job</h3>
                    <button @click="closeCreateModal" class="rounded-lg p-2 text-slate-500 hover:bg-slate-100" aria-label="Close">
                        ✕
                    </button>
                </div>

                <div class="px-5 py-5 space-y-4">
                    <p v-if="formError" class="rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">
                        {{ formError }}
                    </p>

                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-2">Title *</label>
                        <input
                        v-model="form.title"
                        type="text"
                        placeholder="e.g. Frontend Developer"
                        class="w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"/>
                        <p v-if="errors.title" class="mt-1 text-xs text-rose-600">{{ errors.title }}</p>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-2">Company *</label>
                            <input
                                v-model="form.company"
                                type="text"
                                placeholder="e.g. Windmill Ltd"
                                class="w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"/>
                            <p v-if="errors.company" class="mt-1 text-xs text-rose-600">{{ errors.company }}</p>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-2">Location *</label>
                            <input
                                v-model="form.location"
                                type="text"
                                placeholder="e.g. Dhaka / Remote"
                                class="w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"/>
                                <p v-if="errors.location" class="mt-1 text-xs text-rose-600">{{ errors.location }}</p>
                        </div>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-2">Category *</label>
                            <select
                                v-model="form.category_id"
                                class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                <option value="" disabled>Select category</option>
                                <option v-for="c in categories" :key="c.id" :value="c.id">
                                {{ c.name }}
                                </option>
                            </select>
                            <p v-if="errors.category_id" class="mt-1 text-xs text-rose-600">{{ errors.category_id }}</p>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-2">Status</label>
                            <select
                                v-model="form.is_active"
                                class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                <option :value="1">Active</option>
                                <option :value="0">Inactive</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-2">Description</label>
                        <textarea
                        v-model="form.description"
                        rows="4"
                        placeholder="Write job description..."
                        class="w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"></textarea>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-2 border-t border-slate-200 px-5 py-4">
                    <button
                        type="button"
                        @click="closeCreateModal"
                        class="rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-100">
                        Cancel
                    </button>

                    <button
                        type="button"
                        :disabled="saving"
                        @click="createJob"
                        class="rounded-xl bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700 disabled:opacity-60">
                        <span v-if="saving">Saving...</span>
                        <span v-else>Save Job</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- DELETE CONFIRM MODAL -->
        <div v-if="deleteOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4" aria-modal="true" role="dialog">
        
            <div class="absolute inset-0 bg-black/50" @click="cancelDelete"></div>

            <div class="relative w-full max-w-md rounded-2xl bg-white shadow-xl">
                <div class="border-b border-slate-200 px-5 py-4">
                    <h3 class="text-lg font-extrabold text-[#1F2345]">Delete Job</h3>
                    <p class="mt-1 text-sm text-slate-600">
                        Are you sure you want to delete
                        <span class="font-semibold text-slate-900">{{ deletingJob?.title }}</span>?
                    </p>
                </div>

                <div class="flex items-center justify-end gap-2 px-5 py-4">
                    <button
                        type="button"
                        @click="cancelDelete"
                        class="rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-100">
                        Cancel
                    </button>

                    <button
                        type="button"
                        :disabled="deleting"
                        @click="confirmDelete"
                        class="rounded-xl bg-rose-600 px-4 py-2 text-sm font-semibold text-white hover:bg-rose-700 disabled:opacity-60">
                        <span v-if="deleting">Deleting...</span>
                        <span v-else>Delete</span>
                    </button>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import { onMounted, ref, computed, watch } from "vue";
import { useRouter } from "vue-router";
import api from "../../services/api";

const router = useRouter();
const logoutLoading = ref(false);
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

// create modal state
const modalOpen = ref(false);
const saving = ref(false);
const formError = ref("");

const form = ref({
    title: "",
    company: "",
    location: "",
    category_id: "",
    description: "",
    is_active: 1,
});

const errors = ref({
    title: "",
    company: "",
    location: "",
    category_id: "",
});

// delete state
const deleteOpen = ref(false);
const deletingJob = ref(null);
const deleting = ref(false);

// --- UI helpers ---
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

// --- filtering on current page data (client-side) ---
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

    // type filter only if your job has `type`; otherwise it will do nothing
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

watch([q, filters, sortBy], () => {
    page.value = 1;
    fetchJobs();
});

// --- API calls ---
async function fetchJobs() {
    loading.value = true;
    errorMsg.value = "";
    try {
        const res = await api.get("/jobs", { params: { page: page.value } });
        const paginator = res.data?.data;
        jobs.value = paginator?.data ?? [];
        lastPage.value = paginator?.last_page ?? 1;
        total.value = paginator?.total ?? jobs.value.length;
    } catch (err) {
        console.error("jobs load error:", err);
        errorMsg.value = err?.response?.data?.message || "Failed to load jobs.";
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

// --- CREATE ---
function openCreateModal() {
    formError.value = "";
    errors.value = { title: "", company: "", location: "", category_id: "" };
    form.value = {
        title: "",
        company: "",
        location: "",
        category_id: "",
        description: "",
        is_active: 1,
    };
    modalOpen.value = true;
}
function closeCreateModal() {
    modalOpen.value = false;
}

function validateCreate() {
    const f = form.value;
    errors.value.title = f.title?.trim() ? "" : "Title is required.";
    errors.value.company = f.company?.trim() ? "" : "Company is required.";
    errors.value.location = f.location?.trim() ? "" : "Location is required.";
    errors.value.category_id = f.category_id ? "" : "Category is required.";
    return !errors.value.title && !errors.value.company && !errors.value.location && !errors.value.category_id;
}

async function createJob() {
    if (!validateCreate()) return;

    saving.value = true;
    formError.value = "";

    try {
        const payload = {
            title: form.value.title,
            company: form.value.company,
            location: form.value.location,
            category_id: form.value.category_id,
            description: form.value.description,
            is_active: form.value.is_active ? 1 : 0,
        };
        await api.post("/jobs", payload);
        closeCreateModal();
        page.value = 1;
        await fetchJobs();
    } catch (err) {
        console.error("create job error:", err);
        const ve = err?.response?.data?.errors;
        if (ve) {
            errors.value.title = ve.title?.[0] ?? errors.value.title;
            errors.value.company = ve.company?.[0] ?? errors.value.company;
            errors.value.location = ve.location?.[0] ?? errors.value.location;
            errors.value.category_id = ve.category_id?.[0] ?? errors.value.category_id;
            formError.value = err?.response?.data?.message || "Validation error.";
        } else {
            formError.value = err?.response?.data?.message || "Failed to create job.";
        }
    } finally {
        saving.value = false;
    }
}

// --- DELETE ---
function askDelete(job) {
    deletingJob.value = job;
    deleteOpen.value = true;
}
function cancelDelete() {
    deleteOpen.value = false;
    deletingJob.value = null;
}

async function confirmDelete() {
    if (!deletingJob.value?.id) return;

    deleting.value = true;
    try {
        await api.delete(`/jobs/${deletingJob.value.id}`);

        // Optimistic remove from UI
        jobs.value = jobs.value.filter((j) => j.id !== deletingJob.value.id);

        // total adjust (optional)
        total.value = Math.max(0, total.value - 1);

        cancelDelete();

        // if page becomes empty after delete -> go previous page and refetch
        if (jobs.value.length === 0 && page.value > 1) {
        page.value--;
        await fetchJobs();
        }
    } catch (err) {
        console.error("delete job error:", err);
        errorMsg.value = err?.response?.data?.message || "Failed to delete job.";
        cancelDelete();
    } finally {
        deleting.value = false;
    }
}


async function logout() {
    if (logoutLoading.value) return;

    logoutLoading.value = true;

    try {
        await api.post("/logout");
    } catch (err) {        
        console.error("Logout error:", err);
    } finally {
        localStorage.removeItem("token");
        localStorage.removeItem("user");

        logoutLoading.value = false;

        router.push("/");
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