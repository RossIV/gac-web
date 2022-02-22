import Model from './Model'

export default class CurrentUser extends Model {
    // Set the resource route of the model
    resource() {
        return 'user'
    }
}
