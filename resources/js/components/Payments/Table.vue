<template>
    <table class="datatables table table-hover table-bordered text-center small dataTable no-footer dtr-inline">
        <tr>
            <th>METHOD CODE</th>
            <th>SENDER</th>
            <th>ID TYPE</th>
            <th>ID NO</th>
            <th>CREATED AT</th>
            <th>Action</th>
        </tr>
        <template v-for="list in lists">
        <tr>
            <td>{{ list.disbursement_method }}</td>
            <td>{{ list.sender_fname }} {{ list.sender_lname }}</td>
            <td v-if="list.primary_kyc_doc"> {{ list.primary_kyc_doc }} </td>
            <td v-else-if="list.secondary_kyc_doc1"> {{ list.secondary_kyc_doc1 }} </td>
            <td v-else> {{ list.secondary_kyc_doc2 }} </td>
            <td v-if="list.primary_kyc_id"> {{ list.primary_kyc_id }} </td>
            <td v-else-if="list.secondary_kyc_id1"> {{ list.secondary_kyc_id1 }} </td>
            <td v-else> {{ list.secondary_kyc_id2 }} </td>
            <td>{{ list.created_at }}</td>
            <td>
                <button class="btn btn-sm btn-success">USE</button>
                <button class="btn btn-sm btn-primary">EDIT</button>
            </td>
        </tr>
        </template>
    </table>
</template>

<script>
    export default {
        props: ['lists'],
        methods: {
        }
    }
</script>