@extends('layouts.app')

@section('content')
<p style="text-align:center">

  `f(x) = (-b +- sqrt(b^2-4ac))/(2a)`
</p>
<form action="{{ route("tjek-resultat") }}" method="POST">
    {!! csrf_field() !!}
    $${{ $opg }}$$
    $${{ $opg1 }}$$
    $${{ $opg2 }}$$
    <input type="hidden" name="hash" value="{{ $hash }}">
    <input type="hidden" name="question" value="{{ $question }}">
    <input type="text" name="resultat">
    <input type="submit" class="btn btn-primary">
</form>
<div class="container">
    <div class="row clearfix">
        <div class="col-md-9">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Funktion
                    </th>
                    <th>Afledte funktion
                    </th>
                    <th>Eksempel
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr class="warning">
                    <td>$$f(x)=ax+b$$
                    </td>
                    <td>$$f'(x)=a$$
                    </td>
                    <td>$$f(x)=3x+6$$
                        $$f'(x)=3$$
                    </td>
                </tr>
                <tr class="success">
                    <td>$$f(x)=x^n$$
                    </td>
                    <td>$$f'(x)=nx^{n-1}$$
                    </td>
                    <td>$$f(x)=x^3$$
                        $$f'(x)=3x^2$$
                    </td>
                </tr>
                <tr class="warning">
                    <td>$$f(x)=ax+b$$
                    </td>
                    <td>$$f'(x)=a$$
                    </td>
                    <td>$$f(x)=3x+6$$
                        $$f'(x)=3$$
                    </td>
                </tr>
                <tr class="success">
                    <td>$$f(x)=e^x$$
                    </td>
                    <td>$$f'(x)=e^x$$
                    </td>
                    <td></td>
                </tr>
                <tr class="warning">
                    <td>$$f(x)=ln(x)$$
                    </td>
                    <td>$$f'(x)={1\over x}$$
                    </td>
                    <td></td>
                </tr>
                <tr class="success">
                    <td>$$f(x)={\sqrt x=x^{1 \over {2}}}$$
                    </td>
                    <td>$$f'(x)={1 \over {2 \sqrt x}}={1\over 2} x^{-1 \over 2}$$
                    </td>
                    <td></td>
                </tr>
                <tr class="warning">
                    <td>En funktion der ganges med et konstantled, differentieres funktionen og konstanten ganges på.
                        $$f(x)=k \cdot f(x)$$
                    </td>
                    <td>$$f'(x)=k \cdot f'(x)$$
                    </td>
                    <td>$$f(x)=4x^3$$
                        $$f'(x)=4 \cdot 3x^2=12x^2$$
                    </td>
                </tr>
                <tr class="success">
                    <td>En funktion med flere led differentiers ved at differentiere hvert led for sig.
                        $$h(x)=f(x)+g(x)$$
                    </td>
                    <td>$$h'(x)=f'(x)+g'(x)$$
                    </td>
                    <td>$$h(x)=x^2+2x-3$$
                        $$h'(x)=2x+2$$
                    </td>
                </tr>
                <tr class="warning">
                    <td>En funktion med to funktioner der ganges sammen differentieres ved:<br />
                        1.funktion differentieres gange 2.funktion udifferentieret + 1.funktion udifferenteret gange 2.funktion differenteret.
                        $$h(x)=f(x) \cdot g(x)$$
                    </td>
                    <td>$$h'(x)=f'(x)\cdot g(x) + f(x)\cdot g'(x)$$
                        <!--  Bevis
                          <a href="../Formelsamling/bevisproduktformen.aspx" onclick="window.open(this.href, 'child', 'scrollbars,width=850,height=800'); return false">Produktformen</a>-->
                    </td>
                    <td>$$h(x)=x^2\cdot 4x$$
                        $$h'(x)=2x\cdot 4x + x^2\cdot 4$$
                    </td>
                </tr>
                <tr class="success">
                    <td>En funktion med to funktioner der divideres differentieres ved:<br />
                        1.funktion differentieres gange 2.funktion udifferentieret - 1.funktion udifferenteret gange 2.funktion differenteret,
                        divideret med 2.funktion i anden.
                        $$h(x)={f(x)}\\over {g(x)}$$
                    </td>
                    <td>$$h'(x)={f'(x)\cdot g(x) - f(x) \cdot g'(x)}\over {g(x)^2}$$
                    </td>
                    <td>$$h(x)={x^3\over {2x+1}}$$
                        $$h'(x)={3x^2\cdot (2x+1) - x^3 \cdot 2\over (2x+1)^2}$$
                    </td>
                </tr>
                <tr class="warning">
                    <td>En sammensat funktion differentieres ved:<br />
                        Den udvendige differentieres, lad indmaden stå, differentiere indmaden og gang den på.
                        $$h(x)=f(g(x))$$
                    </td>
                    <td>$$h'(x)=f'(g(x))\cdot g'(x)$$
                    </td>
                    <td>$$h(x)=(3x-1)^3$$
                        $$h'(x)=3(3x-1)^2\cdot 3$$
                    </td>
                </tr>
                <tr class="success">
                    <td>$$f(x)=sin(x)$$
                    </td>
                    <td>$$f'(x)=cos(x)$$
                    </td>
                </tr>
                <tr class="warning">
                    <td>$$f(x)=cos(x)$$
                    </td>
                    <td>$$f'(x)=-sin(x)$$
                    </td>
                </tr>
                <tr class="success">
                    <td>$$f(x)=tan(x)$$
                    </td>
                    <td>$$f'(x)={1+ tan^2(x)}={1 \over cos^2(x)}$$
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection