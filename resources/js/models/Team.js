import Model from './Model'

export default class Team extends Model {
    // Set the resource route of the model
    resource() {
        return 'teams'
    }
}
