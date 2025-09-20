<template>
    <div class="row g-2 align-items-center mb-4">
        <div class="col">
            <h2 class="page-title">{{ role.name }} Role Permissions</h2>
        </div>
    </div>
    <div class="row">
        <div class="card">
            <div class="card-header">
                <div class="row g-2 align-items-center w-full my-2">
                    <span class="col m-0">Permissions</span>
                    <label class="form-check m-0 ms-auto col-auto">
                        <input class="form-check-input" type="checkbox" value="1">
                        All
                    </label>
                </div>
            </div>
            <div class="card-body py-5 px-3">
                <form id="syncPermissions" @submit.prevent="syncPermissions">
                    <div class="row g-3">
                        <div class="col-4" v-for="model in Object.keys(groupedPermissions)">
                            <div class="card bg-gray-100 h-full">
                                <div class="card-header">
                                    <label class="form-check m-0">
                                        <input class="form-check-input" type="checkbox" value="1">
                                        {{model}}
                                    </label>
                                </div>
                                <div class="card-body">
                                    <label class="form-check" v-for="permission in Object.values(groupedPermissions[model])">
                                        <input class="form-check-input"
                                               v-model="form.permissions"
                                               type="checkbox"
                                               :value="permission.id">
                                        {{ permission.translate[1] }}
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-footer text-end">
                <button type="submit" class="btn btn-primary ms-auto" form="syncPermissions">
                    <IconDeviceFloppy class="icon" />
                    <span>Save</span>
                </button>
            </div>
        </div>
    </div>
</template>
<script setup>
import {defineProps} from "vue"
import {IconDeviceFloppy} from "@tabler/icons-vue";
import {useForm} from "@inertiajs/vue3";


const props = defineProps({
    role: Object,
    allPermissions: Object,
    selectedPermissions: Array
})

const form = useForm({
    'permissions': props.selectedPermissions
});


let groupedPermissions = Object.groupBy(props.allPermissions, (permission) => permission.translate[0])

for (const [role, permissions] of Object.entries(groupedPermissions)) {
    const sortOrder = ['List', 'View', 'Add', 'Edit', 'Delete']
    const crudPermissions = permissions.filter(permission => sortOrder.includes(permission.translate[1]))
        .sort((a, b) => {
            return sortOrder.indexOf(a.translate[1]) - sortOrder.indexOf(b.translate[1]);
        })

    groupedPermissions[role] = [...new Set(crudPermissions.concat(permissions))]
}

const syncPermissions = () => {
    form.put(route('admin.roles.permissions.update', props.role.id))
}

</script>
