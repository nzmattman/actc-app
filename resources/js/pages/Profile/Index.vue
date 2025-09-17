<template>
  <AuthenticatedLayout title="Profile" :backRoute="route('dashboard')">
    <Head title="Profile" />
    <BlockContent>
      <List>
        <ListItem title="Edit Profile" :route="route('profile.edit')" />
        <ListItem title="Edit Address" :route="route('profile.address.edit')" />
        <ListItem
          title="Update Password"
          :route="route('profile.password.edit')"
        />
        <ListItem
          title="Manage Subscription"
          :route="route('subscriptions.index')"
        />
        <ListItem title="Manage Credit Card" :route="route('profile.card')" />
        <ListItem title="Logout" :route="route('logout')" />
      </List>
    </BlockContent>
  </AuthenticatedLayout>
</template>

<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import BlockContent from '@ui/Blocks/BlockContent.vue';
import List from '@ui/List/List.vue';
import ListItem from '@ui/List/ListItem.vue';
</script>
