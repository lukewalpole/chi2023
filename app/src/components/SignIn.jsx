import { useState, useEffect } from 'react';

/**
 * SignIn
 * 
 * This is a component that allows the user to
 * sign in and out of the website. When they are
 * signed in, they will remain signed in until they
 * log out even if they close the webpage or if the JWT
 * expires.
 * 
 * @author Luke Walpole W20020794
 */
 
function SignIn() {
 
    const [signedIn, setSignedIn] = useState(false)
    const [username, setUsername] = useState('')
    const [password, setPassword] = useState('')
    const [signInError, setSignInError] = useState(false)

    useEffect(
        () => {
            if (localStorage.getItem('token')) {
                setSignedIn(true);
              }}
    )
 
    const signIn = () => {
        const encodedString = btoa(username + ':' + password)

        fetch('https://chi2023-backend.onrender.com/api/token',
        {
            method: 'GET',
            headers: new Headers( { "Authorization": "Basic " + encodedString })
        }
        )
        .then(response => {
            if(response.status === 200) {
                setSignedIn(true)
                setSignInError(false)
            } else {
                setSignInError(true)
            }
            return response.json()
        })
        .then(data => {
            if (data.token) {
                localStorage.setItem('token', data.token)
            }
        })
        .catch(error => console.log(error))
    }
    const signOut = () => {
        setSignedIn(false);
        localStorage.removeItem('token');
    }

    const bgColour = (signInError) ? " bg-red" : " bg-slate-100"
 
    return (
        <div className='bg-peach p-2 text-md text-right text-blue'>
            { !signedIn && <div>
                <input 
                 type="text" 
                 placeholder='username' 
                 className={'p-1 mx-2 rounded-md' + bgColour}
                 value={username}
                 onChange={(e) => setUsername(e.target.value)}
                />
                <input 
                 type="password" 
                 placeholder='password' 
                 className={'p-1 mx-2 rounded-md' + bgColour}
                 value={password}
                 onChange={(e) => setPassword(e.target.value)}
                />
                <input 
                 type="submit" 
                 value='Sign In' 
                 className='py-1 px-2 mx-2 bg-green-100 hover:bg-green-500 rounded-md'
                 onClick={signIn}
                />
            </div>
            }
            { signedIn && <div>
                <input 
                 type="submit" 
                 value='Sign Out' 
                 className='py-1 px-2 mx-2 bg-green-100 hover:bg-green-500 rounded-md'
                 onClick={signOut}
                />
            </div>
            }
            { signInError && <p className='text=blue pr-3.5'>Error with username or password</p>}
        </div>
    )
}
 
export default SignIn;