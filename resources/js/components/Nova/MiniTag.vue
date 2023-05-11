<template>
    <div class="ti-anim-wrap"
         :class="{ 'ti-anim-wrap-active': animActive,
                   'hidden' :             animComplete }"
         ref="wrap"
    >
        <li tabindex="0"
            class="ti-tag ti-valid tag small rounded-full transition duration-300 "
            :class="{ 'ti-deletion-mark': deletion }"
            ref="el"
        >
            <div class="ti-content">
                <div class="ti-tag-center"><span class="">{{ tag }}</span>
                </div>
            </div>
            <div class="ti-actions"><i class="ti-icon-undo"
                                       style="display: none;"></i>
                <svg
                    @click="debouncedHandleChange"
                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" fill="currentColor"
                    class="inline-block ti-svg-icon leading-4 h-4 hover:text-red-500 transition duration-300 ease-out hover:ease-in">
                    <path
                        d="m12.45 38.35-2.8-2.8L21.2 24 9.65 12.45l2.8-2.8L24 21.2 35.55 9.65l2.8 2.8L26.8 24l11.55 11.55-2.8 2.8L24 26.8Z"/>
                </svg>
            </div>
        </li>
    </div>
</template>
<script>
import debounce from 'lodash/debounce'

export default {
    name: 'MiniTag',
    props: ['tag', 'field', 'resourceName', 'resourceId'],
    data: () => ({
        deletion: null,
        animActive: null,
        animComplete: null,
        debouncedHandleChange: null,
    }),

    created() {
        this.debouncedHandleChange = debounce(() => this.startDeletion(), 500)
    },

    methods: {
        startDeletion() {
            this.deletion = !this.deletion;
            this.saveDeletion();
        },
        slideOut() {
            let el = this.$refs.el;
            let wrap = this.$refs.wrap;
            let width = getComputedStyle(wrap).width;
            let height = getComputedStyle(wrap).height;
            wrap.style.width = width;
            wrap.style.height = height;
            this.animActive = true;
            let self = this;
            setTimeout(function() {
                self.animComplete = true;
            }, 1000)
            // wrap.classList.add('ti-anim-wrap-active');
            // el.outerHTML = `<div class="relative ti-anim-wrap overflow-none" style="width: ${width}px; height: ${height}px;">${el.outerHTML}</div>`;
        },
        saveDeletion() {
            const vm = this;
            if (this.deletion) {
                if (!this.loading) {
                    Nova.request().post(
                        // nova-vendor/spatie/nova-tags-field/update/
                        `/nova-vendor/spatie/nova-tags-field/update/${this.resourceName}`,
                        {
                            id: this.field.id,
                            attribute: this.field.attribute,
                            value: this.value,
                            tag: this.tag,
                        }
                    )
                        .then(function (response) {
                            vm.loading = false;
                            vm.slideOut();
                            // vm.field.value = vm.value
                            Nova.$toasted.show('Tag Removed (MiniTag)', {type: 'success'})
                        })
                        .catch(function (error) {
                            vm.loading = false
                            console.log(error);

                            if (error.response.status === 422) {
                                let validationErrors = [];

                                error.response.data.errors.value.forEach(function (errorMessage) {
                                    validationErrors.push(errorMessage.replace('value', vm.field.name));
                                });

                                vm.$toasted.show(validationErrors.join('<br>'), {type: 'error'});
                            }
                        })
                }
                this.loading = true;
            }
        },
        setInitialValue() {
            this.value = String(this.field.value) || ''
        },
        fill(formData) {
            formData.append(this.field.attribute, this.value || '')
        },
        handleChange(value) {
            this.value = value
        },
    },


}
</script>
<style scoped>

[class^="ti-icon-"], [class*=" ti-icon-"] {
    font-family: 'icomoon' !important;
    speak: none;
    font-style: normal;
    font-weight: normal;
    font-variant: normal;
    text-transform: none;
    line-height: 1;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
}

/*
ul {
    margin: 0px;
    padding: 0px;
    list-style-type: none; }

*, *:before, *:after {
    box-sizing: border-box; }

input:focus {
    outline: none; }

input[disabled] {
    background-color: transparent; }
*/

div.vue-tags-input.disabled * {
    cursor: default;
}

.ti-tags {
    display: flex;
    flex-wrap: wrap;
    width: 100%;
    line-height: 1em;
}

.ti-tag {
    background-color: #5C6BC0;
    color: #fff;
    border-radius: 2px;
    display: flex;
    padding: 2px 5px;
    margin: 2px;
    font-size: .85em;
}

.ti-tag:focus {
    outline: none;
}

.ti-tag .ti-content {
    display: flex;
    align-items: center;
}

.ti-tag .ti-tag-center {
    position: relative;
}

.ti-tag span {
    line-height: .85em;
}

.ti-tag span.ti-hidden {
    padding-left: 14px;
    visibility: hidden;
    height: 0px;
    white-space: pre;
}

.ti-tag .ti-actions {
    margin-left: 2px;
    display: flex;
    align-items: center;
    font-size: 1.15em;
}

.ti-tag .ti-actions i {
    cursor: pointer;
}

.ti-tag:last-child {
    margin-right: 4px;
}

.ti-tag.ti-invalid, .ti-tag.ti-tag.ti-deletion-mark {
    background-color: #e54d42;
}

.ti-new-tag-input-wrapper {
    display: flex;
    flex: 1 0 auto;
    padding: 3px 5px;
    margin: 2px;
    font-size: .85em;
}

.ti-new-tag-input-wrapper input {
    flex: 1 0 auto;
    min-width: 100px;
    border: none;
    padding: 0px;
    margin: 0px;
}

.ti-new-tag-input {
    line-height: initial;
}

.ti-autocomplete {
    border: 1px solid #ccc;
    border-top: none;
    position: absolute;
    width: 100%;
    background-color: #fff;
    z-index: 20;
}

.ti-item > div {
    cursor: pointer;
    padding: 3px 6px;
    width: 100%;
}

.ti-selected-item {
    background-color: #5C6BC0;
    color: #fff;
}

.ti-tag {
    background-color: #5C6BC0;
    color: #fff;
    border-radius: 99999px;
    display: flex;
    padding: 3px 5px;
    margin: 2px;
    font-size: .85em;
}

.ti-tag:focus {
    outline: none;
}

.ti-tag .ti-content {
    display: flex;
    align-items: center;
}

.ti-tag .ti-tag-center {
    position: relative;
}

.ti-tag span {
    line-height: .85em;
    padding-left: 0.25em;
}

.ti-tag .ti-actions {
    margin-left: 2px;
    display: flex;
    align-items: center;
    font-size: 1.15em;
}

.ti-tag .ti-actions i {
    cursor: pointer;
}

.ti-tag:last-child {
    margin-right: 4px;
}

.ti-new-tag-input-wrapper input {
    flex: 1 0 auto;
    min-width: 100px;
    border: none;
    padding: 0px;
    margin: 0px;
}

.ti-item > div {
    cursor: pointer;
    padding: 3px 6px;
    width: 100%;
}

.vue-tags-input {
    max-width: 450px;
    position: relative;
    background-color: #fff;
}

div.vue-tags-input.disabled {
    opacity: 0.5;
}

div.vue-tags-input.disabled * {
    cursor: default;
}

.ti-input {
    border: 1px solid #ccc;
    display: flex;
    padding: 4px;
    flex-wrap: wrap;
}

.ti-tag.bg-primary {
    --tw-border-opacity: 1;
    border-color: hsl(var(--p) / var(--tw-border-opacity));
    --tw-bg-opacity: 1;
    background-color: hsl(var(--p) / var(--tw-bg-opacity));
    --tw-text-opacity: 1;
    color: hsl(var(--pc) / var(--tw-text-opacity));
}

.ti-tag.bg-secondary {
    --tw-border-opacity: 1;
    border-color: hsl(var(--s) / var(--tw-border-opacity));
    --tw-bg-opacity: 1;
    background-color: hsl(var(--s) / var(--tw-bg-opacity));
    --tw-text-opacity: 1;
    color: hsl(var(--sc) / var(--tw-text-opacity));
}

.ti-tag.bg-info {
    --tw-border-opacity: 1;
    border-color: hsl(var(--in) / var(--tw-border-opacity));
    --tw-bg-opacity: 1;
    background-color: hsl(var(--in) / var(--tw-bg-opacity));
    --tw-text-opacity: 1;
    color: hsl(var(--inc) / var(--tw-text-opacity));
}

.ti-tag span[data-v-f4aa46aa].p-0 {
    padding: 0;
}

/* slide left animation */

.ti-anim-wrap {
    border: 0;
    margin: 0;
    padding: 0;
    position: relative;
}
.ti-anim-wrap-active {
    overflow: hidden;
}

.ti-anim-wrap-active > .ti-tag {
    position: absolute;
    transform: translateX(-120%);
}
</style>
