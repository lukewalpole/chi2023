import { useEffect, useState } from 'react'
import Content from '../components/Content'

/**
 * ContentListing
 * 
 * This is the content list component. It fetches
 * data from the web API and displays information
 * from the content endpoint.
 * 
 * @author Luke Walpole W20020794
 */
 
function ContentListing() {
 
 
    const [contents, setContent] = useState([])
    const [page, setPage] = useState(1)
 
 
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
            console.log(json)
            setContent(json)
        } else {
            throw new Error("invalid JSON: " + json)
        }
    }
     
    const fetchData = () => { 
        fetch('https://w20020794.nuwebspace.co.uk/coursework/api/content')
        .then( response => handleResponse(response) )
        .then( json => handleJSON(json) )
        .catch( err => { console.log(err.message) })
    }
 
    // Work out where to slice the array
    const startOfPage = (page - 1) * 20
    const endOfPage = startOfPage + 20
 
    // Slice the array and map it to JSX
    const contentJSX = contents.slice(startOfPage,endOfPage).map( 
        (content, i) => <Content key={i} count={i} content={content} /> 
    ) 
 
    // Work out if we're on the first or last page
    const lastPage = (contentJSX.length === 0)
    const firstPage = (page <= 1)
 
    // Functions to change the page
    const nextPage = () => {
        if (lastPage === false) {
            setPage( page => page + 1 )
        }
    }
 
    // Functions to change the page
    const previousPage = () => {
        if (firstPage === false) {
            setPage( page => page - 1 )
        }
    }
 
    // Disable the buttons if we're on the first or last page
    const prevDisabled = (firstPage) ? 'disabled' : ''
    const nextDisabled = (lastPage) ? 'disabled' : ''
 
    return (
        <>
            <h1 className='text-4xl text-red text-left p-5'>Content</h1>
            <div className="grid md:grid-cols-2 lg:grid-cols-4">
                {contentJSX}
            </div>
            <button className='bg-peach text-xl text-red text-center m-2 p-2 rounded-md hover:shadow-lg active:bg-grey' onClick={previousPage} disabled={prevDisabled}>Previous</button>
            <button className='bg-peach text-xl text-red text-center m-2 p-2 rounded-md hover:shadow-lg active:bg-grey' onClick={nextPage} disabled={nextDisabled}>Next</button>
        </>
    )
}
 
export default ContentListing