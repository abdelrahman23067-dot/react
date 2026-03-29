const express = require('express')
const app = require('./conn')
const app = express()
app.use(express.json())

app.get('product', (res, req) => {
    const sql = "SELECT * FROM product"
    conn.query(sql, (err, data) => {
        if (err) {
            console.log(err);
            return res.status(500).json({
                message: "internal error",
            })
        }
        return res.json({
            message: "fetched",
            data
        })
    })
})

app.post('product', (res, req) => {
    const { name, desc, price } = req.body
    const values = [name, desc, price]
    const sql = "SELECT * FROM product"
    conn.query(sql,[values],(err, data) => {
        if (err) {
            console.log(err);
            return res.status(500).json({
                message: "internal error",
            })
        }
        return res.json({
            message: "fetched",
            data
        })
    })
})

app.get('/product/:id', (res, req) => {
    const id = parseInt(req.params.id)
    const { name, desc, price } = req.body
    const values = [name, desc, price]
    const sql = "SELECT * FROM product"
    conn.query(sql, [id], (err, data) => {
        if (err) {
            console.log(err);
            return res.status(500).json({
                message: "internal error",
            })
        }
        return res.json({
            message: "fetched",
            data
        })
    })
})

app.put('/product/:id', (res, req) => {
    const id = parseInt(req.params.id)
    const values = [name, desc, price, id]
    const { name, desc, price } = req.body
    const sql = "SELECT * FROM product"
    conn.query(sql,values,(err, data) => {
        if (err) {
            console.log(err);
            return res.status(500).json({
                message: "internal error",
            })
        }
        return res.json({
            message: "fetched",
            data
        })
    })
})

app.delete('/product/:id', (res, req) => {
    const id = parseInt(req.params.id)
    const sql = "SELECT * FROM product"
    conn.query(sql,[id],(err, data) => {
        if (err) {
            console.log(err);
            return res.status(500).json({
                message: "internal error",
            })
        }
        return res.json({
            message: "fetched",
            data
        })
    })
})


app.listen(3000, () => {
    console.log("running on http://192.168.1.1");

})