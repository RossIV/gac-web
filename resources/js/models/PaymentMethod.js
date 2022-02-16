import Model from './Model'

export default class PaymentMethod extends Model {
    // Set the resource route of the model
    resource() {
        return 'paymentMethods'
    }
}
