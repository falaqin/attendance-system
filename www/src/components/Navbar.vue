<script setup>
import { reactive, watch } from 'vue';
import { Disclosure, DisclosureButton, DisclosurePanel, Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue'
import { Bars3Icon, BellIcon, XMarkIcon, UserCircleIcon } from '@heroicons/vue/24/outline'
import router from '@/router';  
import { RouterLink, useRoute } from 'vue-router';
import { useAuthStore } from '@/stores';

const route = useRoute();
const navigation = reactive([]);
const currentRoutePath = router.currentRoute.value.path;
const auth = useAuthStore();


router.options.routes.forEach((route) => {
    // Check if the route has a name and is not empty
    if (route.name == 'StaffLayout' && !auth.admin) {
        if (route.children) {
            route.children.forEach((childRoute) => {
                if (childRoute.show) {
                    navigation.push({
                        name: childRoute.show,
                        href: `${route.path}/${childRoute.path}`,
                        current: `${route.path}/${childRoute.path}` === `${currentRoutePath}`,
                    });
                }
            })
        }
    } else if (route.name == 'AdminLayout' && auth.admin) {
        if (route.children) {
            route.children.forEach((childRoute) => {
                if (childRoute.show) {
                    navigation.push({
                        name: childRoute.show,
                        href: `${route.path}/${childRoute.path}`,
                        current: `${route.path}/${childRoute.path}` === `${currentRoutePath}`,
                    });
                }
            })
        }
    }
});

const signOut = () => {
    auth.logout();
}

watch(route, (to) => {
    let path = to.path;

    navigation.forEach(nav => {
        if (nav.current && nav.href != path) {
            nav.current = false;
        }

        if (nav.href == path) {
            nav.current = true;
        }
    })
})

</script>

<!-- Copy pasted from tailwind headless lol thank u for the code hehe -->

<template>
    <Disclosure as="nav" class="bg-gray-800" v-slot="{ open }">
        <div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
            <div class="relative flex h-16 items-center justify-between">
                <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
                    <!-- Mobile menu button-->
                    <DisclosureButton
                        class="relative inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-gray-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white">
                        <span class="absolute -inset-0.5" />
                        <span class="sr-only">Open main menu</span>
                        <Bars3Icon v-if="!open" class="block h-6 w-6" aria-hidden="true" />
                        <XMarkIcon v-else class="block h-6 w-6" aria-hidden="true" />
                    </DisclosureButton>
                </div>
                <div class="flex flex-1 items-center justify-center sm:items-stretch sm:justify-start">
                    <div class="flex flex-shrink-0 items-center">
                        <article class="prose">
                            <template v-if="auth.admin">
                                <h1 class="text-gray-700 dark:text-gray-300 cursor-default">Admin</h1>
                            </template>
                            <template v-else-if="!auth.admin">
                                <h1 class="text-gray-700 dark:text-gray-300 cursor-default">Staff</h1>
                            </template>
                        </article>
                    </div>
                    <div class="hidden sm:ml-6 sm:block">
                        <div class="flex space-x-4">
                            <RouterLink v-for="item in navigation" :key="item.name" :to="item.href" @click="$router.push(item.href)"
                                :class="[item.current ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white', 'rounded-md px-3 py-2 text-sm font-medium']"
                                :aria-current="item.current ? 'page' : undefined">{{ item.name }}</RouterLink>
                        </div>
                    </div>
                </div>
                <div class="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">
                    <button type="button"
                        class="relative rounded-full bg-gray-800 p-1 text-gray-400 hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800">
                        <span class="absolute -inset-1.5" />
                        <span class="sr-only">View notifications</span>
                        <BellIcon class="h-6 w-6" aria-hidden="true" />
                    </button>

                    <!-- Profile dropdown -->
                    <Menu as="div" class="relative ml-3">
                        <div>
                            <MenuButton
                                class="relative flex rounded-full bg-gray-800 text-sm focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800">
                                <span class="absolute -inset-1.5" />
                                <span class="sr-only">Open user menu</span>
                                    <UserCircleIcon class="h-8 w-8 rounded-full"/>
                            </MenuButton>
                        </div>
                        <transition enter-active-class="transition ease-out duration-100"
                            enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100"
                            leave-active-class="transition ease-in duration-75"
                            leave-from-class="transform opacity-100 scale-100"
                            leave-to-class="transform opacity-0 scale-95">
                            <MenuItems
                                class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                                <MenuItem v-slot="{ active }">
                                    <span @click="signOut" :class="[active ? 'bg-gray-100' : '', 'block px-4 py-2 text-sm text-gray-700']" class="cursor-pointer">Sign out</span>
                                </MenuItem>
                            </MenuItems>
                        </transition>
                    </Menu>
                </div>
            </div>
        </div>

        <DisclosurePanel class="sm:hidden">
            <div class="space-y-1 px-2 pb-3 pt-2">
                <DisclosureButton v-for="item in navigation" :key="item.name" as="span" @click="$router.push(item.href)"
                    :class="[item.current ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white', 'block rounded-md px-3 py-2 text-base font-medium']"
                    :aria-current="item.current ? 'page' : undefined">{{ item.name }}</DisclosureButton>
            </div>
        </DisclosurePanel>
    </Disclosure>
</template>