<template>
    <default-field :field="field" :errors="errors">
        <template slot="field">
            <input
                :id="field.name"
                type="text"
                class="w-full form-control form-input form-input-bordered quan-tieungao"
                :class="errorClasses"
                :placeholder="field.name"
                v-model.lazy="value"
                v-money="money"
            /> {{value}}
        </template>
    </default-field>
</template>

<script>
import {VMoney} from 'v-money'
import { FormField, HandlesValidationErrors } from 'laravel-nova'

export default {
    mixins: [FormField, HandlesValidationErrors],

    props: ['resourceName', 'resourceId', 'field'],

    data () {
        return {
            price: 123.45,
            money: {
                decimal: ',',
                thousands: '.',
                prefix: 'R$ ',
                suffix: ' #',
                precision: 2,
                masked: false /* doesn't work with directive */
            }
        }
    },

    directives: {money: VMoney},

    methods: {
        /*
         * Set the initial, internal value for the field.
         */
        setInitialValue() {
            this.value = this.field.value || ''
        },

        /**
         * Fill the given FormData object with the field's internal value.
         */
        fill(formData) {
            formData.append(this.field.attribute, this.value || '')
        },

        /**
         * Update the field's internal value.
         */
        handleChange(value) {
            this.value = value
        },
    },
}
</script>
