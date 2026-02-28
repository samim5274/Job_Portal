<template>
    <section class="w-full bg-white">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-10 lg:py-12">
            <!-- Header -->
            <div class="flex items-center justify-between gap-4">
                <h2 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-[#1F2345]">
                Explore by <span class="text-[#2F8CFF]">category</span>
                </h2>

                <a @click="ShowAllJobs" class="inline-flex items-center gap-2 text-sm font-semibold text-indigo-600 hover:opacity-90">
                Show all jobs <span aria-hidden="true">→</span>
                </a>
            </div>

            <!-- Error -->
            <p v-if="errorMsg" class="mt-6 text-sm text-rose-600">
                {{ errorMsg }}
            </p>

            <!-- Loading skeleton -->
            <div v-if="loading" class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                <div
                v-for="i in 8"
                :key="i"
                class="w-full rounded-xl border border-[#E7E8FF] bg-white p-5"
                >
                    <div class="h-10 w-10 rounded-lg bg-slate-100 animate-pulse"></div>
                    <div class="mt-4 h-4 w-24 rounded bg-slate-100 animate-pulse"></div>
                    <div class="mt-3 h-3 w-32 rounded bg-slate-100 animate-pulse"></div>
                </div>
            </div>

            <!-- Grid -->
            <div v-else class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                <div
                v-for="c in uiCategories.slice(0, 8)"
                :key="c.key"
                class="group w-full rounded-xl border border-[#E7E8FF] bg-white p-5 transition-all duration-200
                        hover:-translate-y-1 hover:bg-indigo-600 hover:border-indigo-600
                        hover:shadow-[0_18px_50px_-38px_rgba(79,70,229,0.55)]">
                    <!-- Icon -->
                    <div
                        class="mb-4 inline-flex h-10 w-10 items-center justify-center rounded-lg bg-indigo-50 transition
                            group-hover:bg-white/15">
                        <i
                        :class="[c.iconClass]"
                        class="text-xl leading-none text-indigo-600 transition group-hover:text-white"
                        ></i>
                    </div>

                    <!-- Title -->
                    <div class="text-sm font-extrabold text-[#1F2345] transition group-hover:text-white">
                        {{ c.title }}
                    </div>

                    <!-- Footer row -->
                    <div class="mt-2 flex items-center justify-between">
                        <div class="text-xs text-slate-500 transition group-hover:text-white/80">
                        {{ c.jobs + 5 }} jobs available
                        </div>
                        <span class="text-lg leading-none text-slate-500 transition group-hover:text-white/90">→</span>
                    </div>
                </div>

                <!-- Empty state -->
                    <p v-if="uiCategories.length === 0" class="col-span-full mt-2 text-sm text-slate-500">
                    No categories found.
                    </p>
            </div>
        </div>
    </section>
</template>

<script setup>
import { onMounted, ref, computed } from "vue";
import api from "../services/api";
import { useRouter } from "vue-router";

const router = useRouter();

async function ShowAllJobs() {
    router.push('/show-all-jobs')
}

const loading = ref(false);
const errorMsg = ref("");
const categories = ref([]);


const iconMap = {
    "Software & IT": "fa-solid fa-laptop-code",
    "Design & Creative": "fa-solid fa-pen-nib",
    "Marketing & Sales": "fa-solid fa-bullhorn",
    "Accounts & Finance": "fa-solid fa-wallet",
    "HR & Admin": "fa-solid fa-users-gear",
    "Customer Support": "fa-solid fa-headset",
    "Engineering": "fa-solid fa-gears",
    "Education & Training": "fa-solid fa-graduation-cap",
};

const uiCategories = computed(() => {
    return (categories.value ?? []).map((c) => {
        const title = c.title ?? c.name ?? "Untitled";
        const key = c.key ?? c.slug ?? title.toLowerCase().replace(/\s+/g, "-") ?? String(c.id ?? Math.random());
        return {
            key,
            title,
            jobs: c.jobs ?? c.jobs_count ?? c.total_jobs ?? 0,
            iconClass: c.iconClass ?? c.icon ?? iconMap[title] ?? "fa-solid fa-briefcase",
        };
    });
});

async function getCategorices() {
    loading.value = true;
    errorMsg.value = "";

    try {
        const res = await api.get("/categories");
        categories.value = res.data?.data ?? [];
    } catch (err) {
        console.error("categories load error:", err);
        errorMsg.value = "Failed to load categories.";
        categories.value = [];
    } finally {
        loading.value = false;
    }
}

onMounted(getCategorices);
</script>