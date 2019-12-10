<template>
    <li class="nav-item dropdown no-arrow mx-1">
        <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-envelope fa-fw"></i>
        <!-- Counter - Messages -->
        <span class="badge badge-danger badge-counter">{{ $store.state.Profile.UnreadMessage != 0 ? $store.state.Profile.UnreadMessage : '' }}</span>
        </a>

        <slot></slot>
    </li>
</template>

