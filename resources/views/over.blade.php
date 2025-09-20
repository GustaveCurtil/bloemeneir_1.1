@extends('_layout')

@section('title', 'landing')

@section('main')

    <main id="gallerij">
        <section>
            @for ($i = 1; $i < 33; $i++)
                <img src="{{asset('/media/bloemen/boeket' . $i . '.jpg')}}" alt="">
            @endfor
                    
        </section>
            <p>
            Lorem ipsum dolor, sit amet consectetur adipisicing elit. Natus expedita atque ducimus asperiores molestiae nesciunt! Saepe culpa quidem veniam laborum quos quaerat ab, vero itaque, voluptatum quo deleniti quasi tempore.
            Lorem ipsum dolor, sit amet consectetur adipisicing elit. Numquam sapiente doloribus fugit dolorum libero, dolor explicabo perspiciatis illo vero autem debitis beatae voluptates aperiam? Aperiam voluptates molestiae omnis porro cupiditate?
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Ut sapiente exercitationem quod quas praesentium incidunt veniam possimus itaque sit repellendus, fuga, reiciendis doloribus! Laboriosam a porro ex deserunt distinctio placeat?
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Placeat adipisci beatae dolorem molestias, id voluptatum dolores, suscipit nisi consequuntur consectetur velit vel? Corrupti, iste tenetur! Illum modi sunt fugit distinctio?
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Quasi totam voluptatem aspernatur impedit ut. Cumque consequuntur perspiciatis ipsa, a fugit facere nisi atque quia, in repellendus incidunt ullam deleniti ipsum.
            Lorem ipsum dolor, sit amet consectetur adipisicing elit. Reprehenderit voluptates illum accusamus atque ab, corporis quae asperiores delectus officiis ut, tenetur repudiandae consequuntur deleniti dicta impedit molestiae minima? In, magnam?
            Lorem ipsum dolor sit amet consectetur, adipisicing elit. Quam inventore minima repellat eum null        Lorem ipsum dolor, sit amet consectetur adipisicing elit. Natus expedita atque ducimus asperiores molestiae nesciunt! Saepe culpa quidem veniam laborum quos quaerat ab, vero itaque, voluptatum quo deleniti quasi tempore.
            Lorem ipsum dolor, sit amet consectetur adipisicing elit. Numquam sapiente doloribus fugit dolorum libero, dolor explicabo perspiciatis illo vero autem debitis beatae voluptates aperiam? Aperiam voluptates molestiae omnis porro cupiditate?
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Ut sapiente exercitationem quod quas praesentium incidunt veniam possimus itaque sit repellendus, fuga, reiciendis doloribus! Laboriosam a porro ex deserunt distinctio placeat?
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Placeat adipisci beatae dolorem molestias, id voluptatum dolores, suscipit nisi consequuntur consectetur velit vel? Corrupti, iste tenetur! Illum modi sunt fugit distinctio?
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Quasi totam voluptatem aspernatur impedit ut. Cumque consequuntur perspiciatis ipsa, a fugit facere nisi atque quia, in repellendus incidunt ullam deleniti ipsum.
            Lorem ipsum dolor, sit amet consectetur adipisicing elit. Reprehenderit voluptates illum accusamus atque ab, corporis quae asperiores delectus officiis ut, tenetur repudiandae consequuntur deleniti dicta impedit molestiae minima? In, magnam?
            Lorem ipsum dolor sit amet consectetur, adipisicing elit. Quam inventore minima repellat eum nulla dolor explicabo quod ad. Distinctio rerum reiciendis facere saepe voluptate maiores soluta esse vitae? Quidem, quaerat.
            </p>
    </main>

@endsection
