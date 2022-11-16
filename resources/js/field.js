import IndexField from './components/IndexField'
import DetailField from './components/DetailField'
import FormField from './components/FormField'

Nova.booting((app, store) => {
  app.component('index-nova-visible-password', IndexField)
  app.component('detail-nova-visible-password', DetailField)
  app.component('form-nova-visible-password', FormField)
})
