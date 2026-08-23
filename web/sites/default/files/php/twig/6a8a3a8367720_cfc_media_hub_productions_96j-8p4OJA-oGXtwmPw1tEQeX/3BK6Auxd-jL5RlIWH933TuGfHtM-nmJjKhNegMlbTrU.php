<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\CoreExtension;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Sandbox\SecurityNotAllowedTestError;
use Twig\Source;
use Twig\Template;
use Twig\TemplateWrapper;

/* cfc_media_hub:productions-section */
class __TwigTemplate_92d7aaef48536e7ac5f8594e1720d233 extends Template
{
    private Source $source;
    /**
     * @var array<string, Template>
     */
    private array $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
        $this->sandbox = $this->extensions[SandboxExtension::class];
    }

    protected function doDisplay(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 1
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->extensions['Drupal\Core\Template\TwigExtension']->attachLibrary("core/components.cfc_media_hub--productions-section"));
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->extensions['Drupal\Core\Template\ComponentsTwigExtension']->addAdditionalContext($context, "cfc_media_hub:productions-section"));
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->extensions['Drupal\Core\Template\ComponentsTwigExtension']->validateProps($context, "cfc_media_hub:productions-section"));
        // line 23
        yield "
";
        // line 24
        $context["feat"] = (((CoreExtension::getAttribute($this->env, $this->source, ($context["productions"] ?? null), 0, [], "array", true, true, true, 24) &&  !(null === (($_v0 = ($context["productions"] ?? null)) && is_array($_v0) || $_v0 instanceof ArrayAccess && in_array($_v0::class, CoreExtension::ARRAY_LIKE_CLASSES, true) ? ($_v0[0] ?? null) : CoreExtension::getAttribute($this->env, $this->source, ($context["productions"] ?? null), 0, [], "array", false, false, true, 24))))) ? ((($_v1 = ($context["productions"] ?? null)) && is_array($_v1) || $_v1 instanceof ArrayAccess && in_array($_v1::class, CoreExtension::ARRAY_LIKE_CLASSES, true) ? ($_v1[0] ?? null) : CoreExtension::getAttribute($this->env, $this->source, ($context["productions"] ?? null), 0, [], "array", false, false, true, 24))) : (null));
        // line 25
        $context["rest"] = Twig\Extension\CoreExtension::slice($this->env->getCharset(), ($context["productions"] ?? null), 1);
        // line 26
        yield "
<section class=\"bg-neutral-950 text-white py-36 relative overflow-hidden\">
  <div class=\"absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,_rgba(15,110,86,0.25),_transparent_60%)]\"></div>

  <div class=\"relative max-w-[1440px] mx-auto px-12\">
    <div class=\"flex items-end justify-between mb-14\">
      <div>
        <div class=\"flex items-center gap-3 mb-3\">
          <div class=\"w-5 h-[2px] bg-[#9F5434]\"></div>
          <div class=\"text-[12px] uppercase tracking-[0.18em] text-[#CDEDE3] font-semibold\">Productions</div>
        </div>
        <h2 class=\"tracking-tight\" style=\"font-size: 56px; font-weight: 600; line-height: 1.05; letter-spacing: -0.025em;\">
          Produced at <span class=\"text-[#CDEDE3]\">the Hub.</span>
        </h2>
        <p class=\"text-white/60 max-w-[520px] mt-5 leading-relaxed text-[15px]\">
          Discover interviews, reports and media content created inside CFC Media Hub.
        </p>
      </div>
      <a href=\"";
        // line 44
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["production_url"] ?? null), "html", null, true);
        yield "\" class=\"hidden md:flex items-center gap-2 border border-white/20 hover:bg-white hover:text-neutral-950 transition-colors px-6 py-3 rounded-xl text-[13px] font-medium\">
        Watch all productions
        ";
        // line 46
        yield from $this->load("cfc_media_hub:icon", 46)->unwrap()->yield(CoreExtension::toArray(["name" => "arrow-right", "size" => "w-4 h-4"]));
        // line 47
        yield "      </a>
    </div>

    ";
        // line 50
        if ((($tmp = ($context["feat"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 51
            yield "      <div class=\"grid grid-cols-12 gap-6\">
        <a href=\"";
            // line 52
            yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["production_url"] ?? null), "html", null, true);
            yield "\" class=\"col-span-7 group cursor-pointer block\">
          <div class=\"relative rounded-2xl overflow-hidden h-[460px] bg-white/5\">
            ";
            // line 54
            if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, ($context["feat"] ?? null), "image_url", [], "any", false, false, true, 54)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                // line 55
                yield "              <img src=\"";
                yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["feat"] ?? null), "image_url", [], "any", false, false, true, 55), "html", null, true);
                yield "\" alt=\"";
                yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["feat"] ?? null), "title", [], "any", false, false, true, 55), "html", null, true);
                yield "\" class=\"w-full h-full object-cover group-hover:scale-105 transition-transform duration-700\" />
            ";
            }
            // line 57
            yield "            <div class=\"absolute inset-0 bg-gradient-to-t from-black/85 via-black/20 to-transparent\"></div>
            <div class=\"absolute top-6 left-6 flex items-center gap-2\">
              <span class=\"bg-[#9F5434] text-white px-3 py-1 rounded-full text-[11px] font-semibold\">Featured</span>
              <span class=\"bg-[#9F5434]/80 backdrop-blur text-white px-3 py-1 rounded-full text-[11px] font-semibold\">";
            // line 60
            yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["feat"] ?? null), "type", [], "any", false, false, true, 60), "html", null, true);
            yield "</span>
            </div>
            <div class=\"absolute bottom-6 left-6 right-6\">
              <div class=\"flex items-center gap-3 text-[12px] text-white/80 mb-3\">
                <span class=\"font-semibold\">";
            // line 64
            yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["feat"] ?? null), "publisher", [], "any", false, false, true, 64), "html", null, true);
            yield "</span>
                <span class=\"w-1 h-1 rounded-full bg-white/40\"></span>
                <span class=\"flex items-center gap-1.5\">
                  ";
            // line 67
            yield from $this->load("cfc_media_hub:icon", 67)->unwrap()->yield(CoreExtension::toArray(["name" => "clock", "size" => "w-3 h-3"]));
            // line 68
            yield "                  ";
            yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["feat"] ?? null), "duration", [], "any", false, false, true, 68), "html", null, true);
            yield "
                </span>
              </div>
              <h3 class=\"tracking-tight max-w-[520px]\" style=\"font-size: 32px; font-weight: 600; line-height: 1.15; letter-spacing: -0.02em;\">";
            // line 71
            yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["feat"] ?? null), "title", [], "any", false, false, true, 71), "html", null, true);
            yield "</h3>
            </div>
            <div class=\"absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-20 h-20 rounded-full bg-white/95 text-[#0F6E56] flex items-center justify-center group-hover:scale-110 transition-transform\">
              ";
            // line 74
            yield from $this->load("cfc_media_hub:icon", 74)->unwrap()->yield(CoreExtension::toArray(["name" => "play", "size" => "w-7 h-7 ml-1"]));
            // line 75
            yield "            </div>
          </div>
        </a>

        <div class=\"col-span-5 grid grid-cols-1 gap-6\">
          ";
            // line 80
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(Twig\Extension\CoreExtension::slice($this->env->getCharset(), ($context["rest"] ?? null), 0, 2));
            foreach ($context['_seq'] as $context["_key"] => $context["p"]) {
                // line 81
                yield "            <a href=\"";
                yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["production_url"] ?? null), "html", null, true);
                yield "\">";
                yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->getTemplateForMacro("macro_card", $context, 81, $this->getSourceContext())->macro_card(...[$context["p"], false]));
                yield "</a>
          ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['p'], $context['_parent']);
            $context = array_intersect_key($context, $_parent);
            $context += $_parent;
            // line 83
            yield "        </div>

        <div class=\"col-span-12 grid grid-cols-2 gap-6 mt-2\">
          ";
            // line 86
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(Twig\Extension\CoreExtension::slice($this->env->getCharset(), ($context["rest"] ?? null), 2));
            foreach ($context['_seq'] as $context["_key"] => $context["p"]) {
                // line 87
                yield "            <a href=\"";
                yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["production_url"] ?? null), "html", null, true);
                yield "\">";
                yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->getTemplateForMacro("macro_card", $context, 87, $this->getSourceContext())->macro_card(...[$context["p"], true]));
                yield "</a>
          ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['p'], $context['_parent']);
            $context = array_intersect_key($context, $_parent);
            $context += $_parent;
            // line 89
            yield "        </div>
      </div>
    ";
        }
        // line 92
        yield "  </div>
</section>
";
        $this->env->getExtension('\Drupal\Core\Template\TwigExtension')
            ->checkDeprecations($context, ["productions", "production_url", "horizontal"]);        yield from [];
    }

    // line 1
    public function macro_card($p = null, $horizontal = null, ...$varargs): string|Markup
    {
        $macros = $this->macros;
        $context = [
            "p" => $p,
            "horizontal" => $horizontal,
            "varargs" => $varargs,
        ] + $this->env->getGlobals();

        $blocks = [];

        return ('' === $tmp = implode('', iterator_to_array((function () use (&$context, $macros, $blocks) {
            // line 2
            yield "  <div class=\"group cursor-pointer rounded-2xl overflow-hidden bg-white/[0.04] border border-white/10 hover:border-white/25 transition-colors ";
            yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar((((($tmp = ($context["horizontal"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ("flex") : ("")));
            yield "\">
    <div class=\"relative overflow-hidden bg-white/5 ";
            // line 3
            yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar((((($tmp = ($context["horizontal"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ("w-56 shrink-0") : ("h-44")));
            yield "\">
      ";
            // line 4
            if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, ($context["p"] ?? null), "image_url", [], "any", false, false, true, 4)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                // line 5
                yield "        <img src=\"";
                yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["p"] ?? null), "image_url", [], "any", false, false, true, 5), "html", null, true);
                yield "\" alt=\"";
                yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["p"] ?? null), "title", [], "any", false, false, true, 5), "html", null, true);
                yield "\" class=\"w-full h-full object-cover group-hover:scale-105 transition-transform duration-500\" />
      ";
            }
            // line 7
            yield "      <div class=\"absolute inset-0 bg-gradient-to-t from-black/60 to-transparent\"></div>
      <div class=\"absolute top-3 left-3 bg-[#9F5434] text-white px-2.5 py-1 rounded-full text-[10px] font-semibold\">";
            // line 8
            yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["p"] ?? null), "type", [], "any", false, false, true, 8), "html", null, true);
            yield "</div>
      <div class=\"absolute bottom-3 right-3 w-9 h-9 rounded-full bg-white/95 text-[#0F6E56] flex items-center justify-center\">
        ";
            // line 10
            yield from $this->load("cfc_media_hub:icon", 10)->unwrap()->yield(CoreExtension::toArray(["name" => "play", "size" => "w-3.5 h-3.5"]));
            // line 11
            yield "      </div>
    </div>
    <div class=\"p-5 flex-1\">
      <div class=\"flex items-center gap-2 text-[11px] text-white/60 mb-2\">
        <span class=\"font-semibold\">";
            // line 15
            yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["p"] ?? null), "publisher", [], "any", false, false, true, 15), "html", null, true);
            yield "</span>
        <span class=\"w-1 h-1 rounded-full bg-white/30\"></span>
        <span>";
            // line 17
            yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["p"] ?? null), "duration", [], "any", false, false, true, 17), "html", null, true);
            yield "</span>
      </div>
      <h3 class=\"tracking-tight\" style=\"font-size: 17px; font-weight: 500; line-height: 1.3;\">";
            // line 19
            yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["p"] ?? null), "title", [], "any", false, false, true, 19), "html", null, true);
            yield "</h3>
    </div>
  </div>
";
            yield from [];
        })(), false))) ? '' : new Markup($tmp, $this->env->getCharset());
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "cfc_media_hub:productions-section";
    }

    /**
     * @codeCoverageIgnore
     */
    public function isTraitable(): bool
    {
        return false;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getDebugInfo(): array
    {
        return array (  257 => 19,  252 => 17,  247 => 15,  241 => 11,  239 => 10,  234 => 8,  231 => 7,  223 => 5,  221 => 4,  217 => 3,  212 => 2,  199 => 1,  191 => 92,  186 => 89,  174 => 87,  170 => 86,  165 => 83,  153 => 81,  149 => 80,  142 => 75,  140 => 74,  134 => 71,  127 => 68,  125 => 67,  119 => 64,  112 => 60,  107 => 57,  99 => 55,  97 => 54,  92 => 52,  89 => 51,  87 => 50,  82 => 47,  80 => 46,  75 => 44,  55 => 26,  53 => 25,  51 => 24,  48 => 23,  44 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "cfc_media_hub:productions-section", "themes/custom/cfc_media_hub/components/productions-section/productions-section.twig");
    }
    
    public function ensureSecurityChecked(): void
    {
        if ($this->sandbox->isSandboxed($this->source)) {
            $this->checkSecurity();
        }
    }
    
    public function checkSecurity()
    {
        static $tags = ["macro" => 1, "set" => 24, "include" => 46, "if" => 50, "for" => 80];
        static $filters = ["slice" => 25, "escape" => 44];
        static $functions = [];
        static $tests = [];

        try {
            $this->sandbox->checkSecurity(
                [0 => "macro", 1 => "set", 2 => "include", 3 => "if", 4 => "for"],
                [0 => "slice", 1 => "escape"],
                [],
                [],
                $this->source
            );
        } catch (SecurityError $e) {
            $e->setSourceContext($this->source);

            if ($e instanceof SecurityNotAllowedTagError && isset($tags[$e->getTagName()])) {
                $e->setTemplateLine($tags[$e->getTagName()]);
            } elseif ($e instanceof SecurityNotAllowedFilterError && isset($filters[$e->getFilterName()])) {
                $e->setTemplateLine($filters[$e->getFilterName()]);
            } elseif ($e instanceof SecurityNotAllowedFunctionError && isset($functions[$e->getFunctionName()])) {
                $e->setTemplateLine($functions[$e->getFunctionName()]);
            } elseif ($e instanceof SecurityNotAllowedTestError && isset($tests[$e->getTestName()])) {
                $e->setTemplateLine($tests[$e->getTestName()]);
            }

            throw $e;
        }

    }
}
