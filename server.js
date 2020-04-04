const express = require('express')
const app = express()

const PORT = process.env.PORT || 9000

app.get('/', (req, res) => {
  res.json({
    message: 'OK'
  })
})
app.get('/api-i.php', (req, res) =>  res.status(200){ 
  res.json({
    message: 'OK'
  })
})
app.get('*', (req, res) => {
  res.json({
    message: 'Error'
  })
})

app.listen(PORT, () => {
  console.log(`Server is listening on ${PORT}`)
})
