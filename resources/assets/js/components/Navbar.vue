<template>
    <div class="bg-white border-t">
        <div class="flex mx-auto max-w-md">
            <div class="flex-1">
                <router-link to="/my-podcasts" class="no-underline text-black text-center text-sm block p-2 hover:bg-grey-light">
                    <svg class="h-6 w-6 fill-current text-grey-darkest" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9 11.73a2 2 0 1 1 2 0V20H9v-8.27zm5.24 2.51l-1.41-1.41A3.99 3.99 0 0 0 10 6a4 4 0 0 0-2.83 6.83l-1.41 1.41a6 6 0 1 1 8.49 0zm2.83 2.83l-1.41-1.41a8 8 0 1 0-11.31 0l-1.42 1.41a10 10 0 1 1 14.14 0z"/></svg>
                    <div>My Podcasts</div>
                </router-link>
            </div>
            <div class="flex-1">
                <router-link to="/playlist" class="no-underline text-black text-center text-sm block p-2 hover:bg-grey-light">
                    <svg class="h-6 w-6 fill-current text-grey-darkest" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M16 17a3 3 0 0 1-3 3h-2a3 3 0 0 1 0-6h2a3 3 0 0 1 1 .17V1l6-1v4l-4 .67V17zM0 3h12v2H0V3zm0 4h12v2H0V7zm0 4h12v2H0v-2zm0 4h6v2H0v-2z"/></svg>
                    <div>Playlist</div>
                </router-link>
            </div>
            <div class="flex-1">
                <router-link to="/" class="no-underline text-black text-center text-sm block p-2 hover:bg-grey-light">
                    <svg class="h-6 w-6 fill-current text-grey-darkest" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M16 8A6 6 0 1 0 4 8v11H2a2 2 0 0 1-2-2v-4a2 2 0 0 1 2-2V8a8 8 0 1 1 16 0v3a2 2 0 0 1 2 2v4a2 2 0 0 1-2 2h-2V8zm-4 2h3v10h-3V10zm-7 0h3v10H5V10z"/></svg>
                    <div>Catalog</div>
                </router-link>
            </div>
            <div class="flex-1">
                <router-link to="/profile" class="no-underline text-black text-center text-sm block p-2 hover:bg-grey-light">
                    <svg class="h-6 w-6 fill-current text-grey-darkest" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M5 5a5 5 0 0 1 10 0v2A5 5 0 0 1 5 7V5zM0 16.68A19.9 19.9 0 0 1 10 14c3.64 0 7.06.97 10 2.68V20H0v-3.32z"/></svg>
                    <div>Profile</div>
                </router-link>
            </div>
        </div>
    </div>
</template>
