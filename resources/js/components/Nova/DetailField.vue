<template>
    <PanelItem :index="index" :field="field">
        <template #value>
            <MiniTags
                :name="field.attribute"
                :type="field.type"
                :tags="tags"
                v-model="tags"
            ></MiniTags>
<!--            :suggestion-limit="field.suggestionLimit"-->
<!--            :limit="field.limit"-->
<!--            :errors="errors"-->
<!--            :placeholder="field.placeholder"-->
<!--            :can-be-deselected="field.canBeDeselected"-->
<!--            :label="field.label"-->
<!--            :extra-classes="field.typeClass"-->
        </template>
    </PanelItem>
</template>



<script>
import { FieldValue } from 'laravel-nova';
import MiniTags from "./MiniTags.vue";
import isString from "lodash/isString";
import filter from "lodash/filter";
import values from "lodash/values";

// import { FormField, HandlesValidationErrors } from 'laravel-nova';

export default {
    mixins: [FieldValue],

    props: ['index', 'resource', 'resourceName', 'resourceId', 'field'],

    computed: {
        tagFieldValue() {
            let fieldValue = this.fieldValue
            if (isString(fieldValue)) {
                return filter(fieldValue.split(','), (v) => v.trim().length);
            } else return values(fieldValue);


            // return typeof fieldValue === 'object' ? fieldValue.join(', ') : fieldValue
        },
    },

    components: {
        MiniTags,
    },

    inheritAttrs: false,

    data() {
        return {
            tags: this.field.value,
        };
    },
    methods: {
        fill(formData) {
            formData.append(this.field.attribute, this.tags.join('-----'));
        },

        handleChange(value) {
            this.value = value;
        },
    },
};
</script>
<style scoped>

.material-symbols-outlined {
    font-variation-settings:
        'FILL' 0,
        'wght' 400,
        'GRAD' 0,
        'opsz' 48
}

[class^="ti-icon-"], [class*=" ti-icon-"] {
    font-family: 'icomoon' !important;
    speak: none;
    font-style: normal;
    font-weight: normal;
    font-variant: normal;
    text-transform: none;
    line-height: 1;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale; }

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
.vue-tags-input {
    max-width: 250px;
    position: relative;
}

div.vue-tags-input.disabled {
    opacity: 0.5;
}
div.vue-tags-input.disabled * {
    cursor: default;
}

.ti-input {
    display: flex;
    flex-wrap: wrap;
}

.ti-tags {
    display: flex;
    flex-wrap: wrap;
    width: 100%;
    line-height: 1em;
}

.ti-tag span {
    line-height: .85em;
}
.ti-tag span.ti-hidden {
    padding-left: 14px;
    visibility: hidden;
    height: 0px;
    white-space: pre; }

.ti-tag .ti-actions i {
    cursor: pointer; }

.ti-new-tag-input-wrapper {
    display: flex;
    flex: 1 0 auto;
    padding: 3px 5px;
    margin: 2px;
    font-size: .85em; }
.ti-new-tag-input-wrapper input {
    flex: 1 0 auto;
    min-width: 100px;
    border: none;
    padding: 0px;
    margin: 0px; }

.ti-new-tag-input {
    line-height: initial; }

.ti-autocomplete {
    border: 1px solid #ccc;
    border-top: none;
    position: absolute;
    width: 100%;
    background-color: #fff;
    z-index: 20; }

.ti-item > div {
    cursor: pointer;
    padding: 3px 6px;
    width: 100%; }

.ti-selected-item {
    background-color: #5C6BC0;
    color: #fff; }

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

.ti-tag.hover\:bg-info:hover {
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


</style>
