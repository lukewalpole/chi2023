import { useEffect, useState } from 'react'

/**
 * Home
 * 
 * This is the home page component. It fetches
 * data from the web API and displays information
 * from the preview endpoint.
 * 
 * @author Luke Walpole W20020794
 */
 
function Home() {

    const [previews, setPreviews] = useState([])
 
    useEffect( () => {
        fetchData()
    },[])
 
    const handleResponse = (response) => {
        if (response.status === 200) {
            return response.json()
        } else {
            throw new Error("invalid response: " + response.status)
        }
    }
     
    const handleJSON = (json) => {
        if (json.constructor === Array) {
            setPreviews(json)
        } else {
            throw new Error("invalid JSON: " + json)
        }
    }
     
    const fetchData = () => { 
        fetch('https://w20020794.nuwebspace.co.uk/coursework/api/preview?limit=1')
        .then( response => handleResponse(response) )
        .then( json => handleJSON(json) )
        .catch( err => { console.log(err.message) })
    }
 
    const previewsJSX = previews.map( (preview, i) => 
        <section key={i}>
            <h2 className='text-2xl p-2.5 text-blue text-center'>{preview.title}</h2>
            <p className='text-2xl p-2.5 text-blue text-center'>{preview.preview_video}</p>
        </section>
    ) 
 
    return (
        <>
            <h1 className='text-4xl text-red text-center p-5'>CHI 2023</h1>
            {previewsJSX}
        </>
    )
}
 
export default Home