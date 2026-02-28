<template>
    <section class="w-full bg-white">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8 py-10 lg:py-12">
            <!-- Top bar -->
            <div class="flex items-center justify-between gap-4">
                <button
                class="inline-flex items-center gap-2 rounded-lg px-3 py-2 text-sm font-semibold text-indigo-600 hover:bg-indigo-50 focus:outline-none focus:ring-2 focus:ring-indigo-500/30"
                    @click="router.back()">
                    <span aria-hidden="true">←</span> Back
                </button>

                <div class="hidden sm:flex items-center gap-2 text-xs text-slate-500">
                    <i class="fa-regular fa-clock"></i>
                    <span>Posted:</span>
                    <span class="font-semibold text-slate-700">
                        {{ job.created_at ? formatDate(job.created_at) : "Recently" }}
                    </span>
                </div>
            </div>

            <!-- Loading -->
            <div v-if="loading" class="mt-6 rounded-2xl border border-slate-200 bg-white p-6">
                <div class="h-7 w-2/3 bg-slate-100 animate-pulse rounded"></div>
                <div class="mt-3 h-4 w-1/2 bg-slate-100 animate-pulse rounded"></div>
                <div class="mt-6 h-28 bg-slate-100 animate-pulse rounded"></div>
            </div>

            <!-- Error -->
            <div v-else-if="errorMsg" class="mt-6 rounded-2xl border border-rose-200 bg-rose-50 p-6">
                <p class="text-sm font-semibold text-rose-700">{{ errorMsg }}</p>
                <p class="mt-1 text-sm text-rose-600">Please go back and try another job.</p>
            </div>

            <!-- Content -->
            <div v-else class="mt-6 grid gap-6 lg:grid-cols-3">
                <!-- Left: Job details -->
                <div class="lg:col-span-2">
                    <!-- Hero card -->
                    <div class="rounded-2xl border border-slate-200 bg-white p-6">
                        <div class="flex flex-col gap-5 sm:flex-row sm:items-start sm:justify-between">
                            <div class="min-w-0">
                                <div class="flex flex-wrap items-center gap-2">
                                    <span class="inline-flex items-center gap-2 rounded-full bg-indigo-50 px-3 py-1 text-xs font-semibold text-indigo-700">
                                        <i class="fa-solid fa-briefcase"></i>
                                        {{ displayType(job.type) }}
                                    </span>

                                    <span
                                        v-if="job.remote"
                                        class="inline-flex items-center gap-2 rounded-full bg-violet-50 px-3 py-1 text-xs font-semibold text-violet-700">
                                        <i class="fa-solid fa-wifi"></i> Remote
                                    </span>

                                    <span
                                        v-if="job.category?.name"
                                        class="inline-flex items-center gap-2 rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700">
                                        <i class="fa-solid fa-tag"></i> {{ job.category.name }}
                                    </span>
                                </div>

                                <h1 class="mt-4 text-2xl sm:text-3xl font-extrabold tracking-tight text-[#1F2345]">
                                    {{ job.title ?? "Untitled Job" }}
                                </h1>

                                <div class="mt-2 flex flex-wrap items-center gap-x-4 gap-y-2 text-sm text-slate-600">
                                    <span class="inline-flex items-center gap-2">
                                        <i class="fa-solid fa-building text-slate-400"></i>
                                        {{ job.company ?? "Unknown Company" }}
                                    </span>

                                    <span class="inline-flex items-center gap-2">
                                        <i class="fa-solid fa-location-dot text-slate-400"></i>
                                        {{ job.location ?? "Unknown Location" }}
                                    </span>

                                    <span v-if="job.salary" class="inline-flex items-center gap-2">
                                        <i class="fa-solid fa-wallet text-slate-400"></i>
                                        <span class="font-semibold text-emerald-700">{{ job.salary }}</span>
                                    </span>
                                </div>
                            </div>

                            <!-- small actions -->
                            <div class="flex items-center gap-2">
                                <button
                                type="button"
                                class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm font-semibold text-slate-700
                                        hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-indigo-500/30"
                                @click="copyLink">
                                    <i class="fa-regular fa-copy"></i> Copy link
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Description card -->
                    <div class="mt-6 rounded-2xl border border-slate-200 bg-white p-6">
                        <h3 class="text-sm font-extrabold text-[#1F2345]">Job Description</h3>
                        <div class="mt-3 space-y-3 text-sm leading-6 text-slate-600 whitespace-pre-line">
                        {{ job.description ?? "No description provided." }}
                        </div>
                    </div>

                    <!-- Extra sections (optional) -->
                    <div class="mt-6 grid gap-6 sm:grid-cols-2">
                        <div class="rounded-2xl border border-slate-200 bg-white p-6">
                            <h3 class="text-sm font-extrabold text-[#1F2345]">What you’ll do</h3>
                            <ul class="mt-3 list-disc pl-5 text-sm text-slate-600 space-y-2">
                                <li>Work with the team to deliver high-quality outcomes.</li>
                                <li>Collaborate across design/engineering/business.</li>
                                <li>Improve processes and ship faster.</li>
                            </ul>
                        </div>

                        <div class="rounded-2xl border border-slate-200 bg-white p-6">
                            <h3 class="text-sm font-extrabold text-[#1F2345]">Requirements</h3>
                            <ul class="mt-3 list-disc pl-5 text-sm text-slate-600 space-y-2">
                                <li>Strong communication and problem solving.</li>
                                <li>Relevant experience in the role.</li>
                                <li>Ability to work independently.</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Right: Apply card -->
                <aside class="lg:sticky lg:top-24 h-fit">
                <div class="rounded-2xl border border-slate-200 bg-white p-6">
                    <div class="flex items-center justify-between">
                    <p class="text-sm font-extrabold text-[#1F2345]">Apply for this job</p>
                    <span class="text-xs text-slate-400">
                        ID: <span class="font-semibold text-slate-600">{{ job.id }}</span>
                    </span>
                    </div>

                    <p class="mt-2 text-sm text-slate-600">
                    Ready to apply? Submit your application and we’ll get back to you.
                    </p>

                    <button
                    class="mt-5 w-full rounded-xl bg-indigo-600 px-4 py-3 text-sm font-semibold text-white
                            hover:opacity-95 focus:outline-none focus:ring-2 focus:ring-indigo-500/30"
                    @click="openApply"
                    >
                    Apply Now
                    </button>

                    <button
                    class="mt-3 w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm font-semibold text-slate-700
                            hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-indigo-500/30"
                    @click="saveJob"
                    >
                    <i class="fa-regular fa-bookmark mr-2"></i> Save job
                    </button>

                    <div class="mt-6 border-t border-slate-200 pt-4">
                    <div class="flex items-center justify-between text-xs text-slate-500">
                        <span>Posted</span>
                        <span class="font-semibold text-slate-700">
                        {{ job.created_at ? formatDate(job.created_at) : "Recently" }}
                        </span>
                    </div>
                    <div class="mt-2 flex items-center justify-between text-xs text-slate-500">
                        <span>Type</span>
                        <span class="font-semibold text-slate-700">{{ displayType(job.type) }}</span>
                    </div>
                    <div v-if="job.category?.name" class="mt-2 flex items-center justify-between text-xs text-slate-500">
                        <span>Category</span>
                        <span class="font-semibold text-slate-700">{{ job.category.name }}</span>
                    </div>
                    </div>
                </div>
                </aside>
            </div>

            <!-- Apply Modal -->
            <div
            v-if="applyOpen"
            class="fixed inset-0 z-50 flex items-center justify-center"
            aria-modal="true"
            role="dialog">
                <!-- Backdrop -->
                <div class="absolute inset-0 bg-black/40" @click="closeApply"></div>

                <!-- Panel -->
                <div class="relative w-full max-w-xl rounded-2xl bg-white p-6 shadow-xl">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <h3 class="text-lg font-extrabold text-[#1F2345]">Apply for: {{ job.title }}</h3>
                            <p class="mt-1 text-sm text-slate-500">Fill in the form below to submit your application.</p>
                        </div>
                        <button
                            class="rounded-lg p-2 text-slate-500 hover:bg-slate-100"
                            @click="closeApply"
                            aria-label="Close">
                            ✕
                        </button>
                    </div>

                    <p v-if="applyError" class="mt-4 text-sm text-rose-600">{{ applyError }}</p>
                    <p v-if="applySuccess" class="mt-4 text-sm text-emerald-600">{{ applySuccess }}</p>

                    <form class="mt-5 grid gap-4" @submit.prevent="submitApply">
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1">Name</label>
                            <input
                            v-model="applyForm.name"
                            type="text"
                            class="w-full rounded-xl border border-slate-200 px-3 py-2.5 text-sm
                                    focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            placeholder="Your full name"/>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1">Email</label>
                            <input
                            v-model="applyForm.email"
                            type="email"
                            class="w-full rounded-xl border border-slate-200 px-3 py-2.5 text-sm
                                    focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            placeholder="you@email.com"/>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1">Resume link</label>
                            <input
                            v-model="applyForm.resume_link"
                            type="url"
                            class="w-full rounded-xl border border-slate-200 px-3 py-2.5 text-sm
                                    focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            placeholder="https://drive.google.com/..."/>
                            <p class="mt-1 text-xs text-slate-400">Google Drive / Dropbox / Portfolio link</p>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1">Cover note</label>
                            <textarea
                            v-model="applyForm.cover_note"
                            rows="5"
                            class="w-full rounded-xl border border-slate-200 px-3 py-2.5 text-sm
                                    focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            placeholder="Write a short message..."></textarea>
                        </div>

                        <div class="mt-2 flex items-center justify-end gap-2">
                            <button
                            type="button"
                            class="rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50"
                            @click="closeApply"
                            :disabled="applyLoading">
                                Cancel
                            </button>

                            <button
                            type="submit"
                            class="rounded-xl bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:opacity-95 disabled:opacity-60"
                            :disabled="applyLoading">
                                <span v-if="!applyLoading">Submit Application</span>
                                <span v-else>Submitting...</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import { onMounted, ref , reactive} from "vue";
import { useRoute, useRouter } from "vue-router";
import api from "../../services/api";

const route = useRoute();
const router = useRouter();

const loading = ref(false);
const errorMsg = ref("");
const job = ref({});

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

async function fetchJob() {
    loading.value = true;
    errorMsg.value = "";
    try {
        const res = await api.get(`/jobs/${route.params.id}`);
        job.value = res.data?.data ?? {};
    } catch (err) {
        console.error("job details error:", err);
        errorMsg.value = "Job not found.";
    } finally {
        loading.value = false;
    }
}

function copyLink() {
    const url = window.location.href;
    navigator.clipboard?.writeText(url);
}

function saveJob() {
    alert("Saved (demo).");
}







const applyOpen = ref(false);
const applyLoading = ref(false);
const applyError = ref("");
const applySuccess = ref("");

const applyForm = reactive({
    name: "",
    email: "",
    resume_link: "",
    cover_note: "",
});

function openApply() {
    applyError.value = "";
    applySuccess.value = "";
    applyOpen.value = true;
}

function closeApply() {
    applyOpen.value = false;
}

async function submitApply() {
    applyError.value = "";
    applySuccess.value = "";

    // basic frontend validation
    if (!applyForm.name.trim()) return (applyError.value = "Name is required.");
    if (!applyForm.email.trim()) return (applyError.value = "Email is required.");

    applyLoading.value = true;
    try {
        const payload = {
            job_id: job.value.id,
            name: applyForm.name,
            email: applyForm.email,
            resume_link: applyForm.resume_link || null,
            cover_note: applyForm.cover_note || null,
        };

        const res = await api.post("/job-applications", payload);

        applySuccess.value = res.data?.message || "Application submitted!";
        // optional: clear form
        applyForm.name = "";
        applyForm.email = "";
        applyForm.resume_link = "";
        applyForm.cover_note = "";

        // auto close after success (optional)
        setTimeout(() => {
            applyOpen.value = false;
        }, 900);
    } catch (err) {
        // show Laravel validation errors if exists
        const msg = err?.response?.data?.message ||
        Object.values(err?.response?.data?.errors || {})?.flat()?.[0] || "Failed to submit application.";
        applyError.value = msg;
    } finally {
        applyLoading.value = false;
    }   
}








onMounted(fetchJob);
</script>